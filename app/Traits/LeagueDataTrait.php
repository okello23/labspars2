<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Cache;
use App\Models\Facility\Facility;
use App\Models\District;
use App\Models\Facility\FacilityVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Dashboard\MainDashboardComponent;


trait LeagueDataTrait
{
     public $from_date;
    public $to_date;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = 0;

    public $DistrictIds = [];
    public $filter = false;

    public $region_id;
    public $district_id;
    public $health_sub_district_id;
    public $facility_id;
    public $facility_level;

    public $filter_region_id;
    public $filter_district_id;
    public $filter_health_sub_district_id;
    public $filter_facility_level;

    public $facilities = [];
    public $districts_list = [];
    public $facility_performance_table = 1;

    protected $paginationTheme = 'bootstrap';

    /** ---------------------------------------------------------
     *  INITIALIZE FILTERS
     * --------------------------------------------------------- */
    public function initializeLeagueDataTrait()
    {
        $this->DistrictIds = [];
    }

    /** ---------------------------------------------------------
     *  PAGINATION HOOKS
     * --------------------------------------------------------- */
    public function updatingPerPage()
    {
        $this->resetPage('facility_performance_table');
    }

    public function updatingLeaguePage()
    {
        $this->resetPage('facility_performance_table');
    }

    /** ---------------------------------------------------------
     *  REGION → DISTRICT CASCADE
     * --------------------------------------------------------- */
    public function updatedFilterRegionId($value)
    {
        $this->filter_district_id = '';
        $this->filter_health_sub_district_id = '';
        $this->districts_list = District::where('region_id', $value)->orderBy('name', 'ASC')->get();
    }

    /** ---------------------------------------------------------
     *  DISTRICT → FACILITY CASCADE
     * --------------------------------------------------------- */
    public function updatedDistrictId($id)
    {
        $this->facilities = Facility::whereHas('healthSubDistrict.district', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $this->facility_level = '';
    }

    /** ---------------------------------------------------------
     *  SET FACILITY LEVEL
     * --------------------------------------------------------- */
    public function updatedFacilityId($id)
    {
        $facility = Facility::find($id);
        $this->facility_level = $facility ? $facility->level : null;
    }

    /** ---------------------------------------------------------
     *  RESET FILTERS
     * --------------------------------------------------------- */
    public function resetInputs()
    {
        $this->reset([
            'facility_id',
            'facility_level',
            'district_id'
        ]);
    }

    /** ---------------------------------------------------------
     *  BUILD FILTER ARRAY
     * ---------------------------------------------------------*/
    protected function buildFilters()
    {
        return [
            'filter_from'        => $this->from_date,
            'filter_to'          => $this->to_date,
            'filter_district_id' => $this->filter_district_id,
            'filter_region_id'   => $this->filter_region_id,
        ];
    }

      private function loadAllScores()
    {
        $cache_key = 'league_scores_' . md5(json_encode([
            $this->from_date,
            $this->to_date,
            $this->filter_region_id,
            $this->filter_district_id,
            $this->filter_health_sub_district_id,
            $this->filter_facility_level,
            $this->search,
        ]));
        
        return Cache::remember($cache_key, now()->addMinutes(30), function () {
            $dashboard = new MainDashboardComponent();

            return collect()
                ->merge($dashboard->stockMgtScores())
                ->merge($dashboard->fvTotalStorageScore())
                ->merge($dashboard->fvTotalOrderMgtScore())
                ->merge($dashboard->getCombinedEquipmentScores())
                ->merge($dashboard->fvLisTotalScorePerVisit());
        });
    }

      private function transformScoresToRows($allScores)
    {
        $grouped = $allScores->groupBy('visit_id');

        return $grouped->map(function ($items, $visitId) {
            $stock = optional($items->firstWhere('thematic_area', 'Stock Management'))['score'][0] ?? null;
            $storage = optional($items->firstWhere('thematic_area', 'Storage Management'))['score'][0] ?? null;
            $order = optional($items->firstWhere('thematic_area', 'Order Management'))['score'][0] ?? null;
            $equipment = optional($items->firstWhere('thematic_area', 'Equipment Management'))['score'][0] ?? null;
            $lis = optional($items->firstWhere('thematic_area', 'Lab Information System'))['score'][0] ?? null;

            $total_thematic = collect([$stock, $storage, $order, $equipment, $lis])->filter()->sum();

            return [
                'visit_id'       => $visitId,
                // 'facility_id'    => $items->first()['facility_id'],
                'stock_mgt'      => $stock,
                'storage_mgt'    => $storage,
                'order_mgt'      => $order,
                'equipment_mgt'  => $equipment,
                'lis_mgt'        => $lis,
                'total_thematic' => round($total_thematic, 2),
            ];
        })->values();
    }
    
     private function attachVisitMetaData($rows, $filters = [])
    {
        $visitIds = $rows->pluck('visit_id')->unique()->values()->all();
        
        $visits = FacilityVisit::search($this->search)
        ->with('facility.healthSubDistrict.district.region')
        ->applyVisitFilters($filters)
        ->whereIn('id', $visitIds)
        ->get()
        ->filter(fn ($v) => $v->facility)  // ensure only visits with facility
        ->keyBy('id');
        
        // Attach visit metadata
        return $rows->filter(function ($row) use ($visits) {
            return $visits->has($row['visit_id']);
        })
        ->map(function ($row) use ($visits) {
            $visit = $visits->get($row['visit_id']);

            return (object) [
                'visit_id'            => $row['visit_id'],
                // 'facility_id'         => $row['facility_id'],
                'facility'            => $visit?->facility,
                'visit_number'        => $visit?->visit_number,
                'date_of_visit'       => $visit?->date_of_visit,
                'created_at'          => $visit?->created_at,
                'district'            => $visit?->facility?->healthSubDistrict?->district?->name,
                'region'              => $visit?->facility?->healthSubDistrict?->district?->region?->name,
                'stock_management'    => $row['stock_mgt'],
                'storage_management'  => $row['storage_mgt'],
                'ordering_management' => $row['order_mgt'],
                'equipment_management'=> $row['equipment_mgt'],
                'lis_mgt'             => $row['lis_mgt'],
                'total_score'         => collect([
                    $row['stock_mgt'],
                    $row['storage_mgt'],
                    $row['order_mgt'],
                    $row['equipment_mgt'],
                    $row['lis_mgt'],
                ])->filter()->avg(),
                'total_thematic'      => $row['total_thematic'],
                'visit_code'          => $visit?->visit_code,
            ];
        })->values();
    }

    
    
    /** ---------------------------------------------------------
     *  PREPARE RAW LEAGUE DATA
     * ---------------------------------------------------------*/
    protected function prepareLeagueData(): Collection
    {
        $scores = $this->loadAllScores();
        $rows   = $this->transformScoresToRows($scores);

        return $this->attachVisitMetaData($rows, $this->buildFilters());
    }

    /** ---------------------------------------------------------
     *  FACILITY RANKING (DENSE RANK)
     * ---------------------------------------------------------*/
    protected function rankFacilities(Collection $leagueData): Collection
    {
        $sorted = $leagueData->sortByDesc('total_thematic')->values();

        $rank = 0;
        $lastScore = null;
        $denseRank = 0;

        return $sorted->map(function ($item) use (&$rank, &$lastScore, &$denseRank) {
            $denseRank++;

            if ($lastScore === null || $lastScore !== $item->total_thematic) {
                $rank = $denseRank;
            }

            $lastScore = $item->total_thematic;
            $item->rank = $rank;
            return $item;
        })->values();
    }

    /** ---------------------------------------------------------
     *  DISTRICT LEAGUE LOGIC
     * ---------------------------------------------------------*/
    public function computeDistrictLeague($leagueData)
{
    $district_grouped_visits = $leagueData->groupBy('district');

    $district_summaries = $district_grouped_visits->map(function ($visits, $district_name) {

        $sorted = $visits->sortBy('created_at')->values();

        if ($sorted->count() == 1) {
            $baseline = $sorted->first()->total_score;
            $current  = $sorted->first()->total_score;
        } else {
            $baseline = $sorted->slice(0, $sorted->count() - 1)->avg('total_score');
            $current  = $sorted->last()->total_score;
        }

        $change = round($current - $baseline, 2);
        $percent_change = $baseline > 0
            ? round((($current - $baseline) / $baseline) * 100, 2)
            : null;

        $average_score = round($visits->avg('total_score'), 2);

        return (object) [
            'district'        => $district_name,
            'region'          => $visits->first()->region ?? null,
            'visits_count'    => $visits->count(),
            'facilities'      => $visits->pluck('facility_id')->unique()->count(),
            
            // multiply by 5 (SPARS mac scoring scale)
            'baseline_score'  => round($baseline, 2) * 5,
            'current_score'   => round($current, 2) * 5,
            'change'          => $change * 5,
            'percent_change'  => $percent_change,
            'average_score'   => $average_score * 5,
            'trend_icon'      => $change > 0 ? '▲' : ($change < 0 ? '▼' : '➝')
        ];
    });

    /**
     * --------------------------
     * 1. RANK BY CURRENT SCORE
     * --------------------------
     */
    $sorted = $district_summaries->sortByDesc('current_score')->values();

    $rank = 0;
    $density = 0;
    $last_score = null;

    $ranked = $sorted->map(function ($row) use (&$rank, &$last_score, &$density) {

        $density++;

        if ($last_score === null || $last_score !== $row->current_score) {
            $rank = $density;
        }

        $last_score = $row->current_score;
        $row->rank = $rank;

        return $row;
    });


    /**
     * --------------------------
     * 2. COMPUTE BASELINE RANK
     * --------------------------
     */
    $baseline_sorted = $ranked->sortByDesc('baseline_score')->values();

    $baseline_rank = 0;
    $baseline_density = 0;
    $last_baseline = null;

    foreach ($baseline_sorted as $row) {

        $baseline_density++;

        if ($last_baseline === null || $last_baseline !== $row->baseline_score) {
            $baseline_rank = $baseline_density;
        }

        $last_baseline = $row->baseline_score;
        $row->baseline_rank = $baseline_rank;
    }

    return $baseline_sorted;
}

    

    /** ---------------------------------------------------------
     *  PAGINATION FOR COLLECTIONS
     * ---------------------------------------------------------*/
    protected function paginateCollection(Collection $items, $perPage=10)
    {
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->slice($offset, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
