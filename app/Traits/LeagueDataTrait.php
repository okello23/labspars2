<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Cache;
use App\Models\Facility\Facility;
use App\Models\District;
use App\Models\Facility\FacilityVisit;
use Carbon\Carbon;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Dashboard\MainDashboardComponent;


trait LeagueDataTrait
{
    public $date_filter_type = 'all';
    public $filter_year;
    public $filter_quarter;
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
        $this->date_filter_type = $this->date_filter_type ?: 'all';
        $this->filter_year = $this->filter_year ?: $this->getLatestAvailableVisitDate()->year;
        $this->filter_quarter = $this->filter_quarter ?: ('q' . $this->getLatestAvailableVisitDate()->quarter);
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
        $this->resetPage('facility_performance_table');
        $this->filter_district_id = '';
        $this->filter_health_sub_district_id = '';
        $this->districts_list = District::where('region_id', $value)->orderBy('name', 'ASC')->get();
    }

    public function updatingFilterDistrictId()
    {
        $this->resetPage('facility_performance_table');
    }

    public function updatingFromDate()
    {
        $this->resetPage('facility_performance_table');
    }

    public function updatingToDate()
    {
        $this->resetPage('facility_performance_table');
    }

    public function updatingDateFilterType()
    {
        $this->resetPage('facility_performance_table');
    }

    public function updatedDateFilterType($value)
    {
        if ($value === 'quarterly') {
            $this->normalizeQuarterFilters();
            $this->from_date = null;
            $this->to_date = null;
            return;
        }

        if ($value === 'date_range') {
            $this->filter_year = null;
            $this->filter_quarter = null;
            return;
        }

        $this->from_date = null;
        $this->to_date = null;
        $this->filter_year = null;
        $this->filter_quarter = null;
    }

    public function updatingFilterYear()
    {
        $this->resetPage('facility_performance_table');
    }

    public function updatingFilterQuarter()
    {
        $this->resetPage('facility_performance_table');
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
        [$filterFrom, $filterTo] = $this->resolveDateFilters();

        return [
            'filter_from'        => $filterFrom,
            'filter_to'          => $filterTo,
            'filter_district_id' => $this->filter_district_id,
            'filter_region_id'   => $this->filter_region_id,
        ];
    }
    
    private function loadAllScores()
    {
        if (!Auth::check()) {
            return collect();
        }

        $cache_key = 'league_scores_' . md5(json_encode([
            Auth::id(),
            $this->date_filter_type,
            $this->filter_year,
            $this->filter_quarter,
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
            
            // Fetch actual visit to pull created_at
            $visit = FacilityVisit::find($visitId);
    
            $stock = optional($items->firstWhere('thematic_area', 'Stock Management'))['score'][0] ?? null;
            $storage = optional($items->firstWhere('thematic_area', 'Storage Management'))['score'][0] ?? null;
            $order = optional($items->firstWhere('thematic_area', 'Order Management'))['score'][0] ?? null;
            $equipment = optional($items->firstWhere('thematic_area', 'Equipment Management'))['score'][0] ?? null;
            $lis = optional($items->firstWhere('thematic_area', 'Lab Information System'))['score'][0] ?? null;
            
            $total_thematic = collect([$stock, $storage, $order, $equipment, $lis])
                ->filter()
                ->sum();
                
                return [
                    'visit_id'       => $visitId,
                    'facility_id'    => $items->first()['facility_id'],
                    'created_at'     => date('Y-m-d', strtotime($visit->created_at)) ?? null,
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
                'facility_id'         => $row['facility_id'],
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
           
           // All visits sorted by date
           $sorted = $visits->sortBy(function ($visit) {
               return $this->resolveVisitDate($visit);
           })->values();
           if ($sorted->isEmpty()) {
               return null;
           }
           
           // 1. Determine the quarter of the most recent visit
           $latestVisit = Carbon::parse($this->resolveVisitDate($sorted->last()));
           $currentQuarter = $latestVisit->quarter;
           $currentYear = $latestVisit->year;
   
           // 2. Previous quarter & year
           if ($currentQuarter == 1) {
               $previousQuarter = 4;
               $previousYear = $currentYear - 1;
           } else {
               $previousQuarter = $currentQuarter - 1;
               $previousYear = $currentYear;
           }
           
           // 3. Filter visits into quarters
           $currentQuarterVisits = $sorted->filter(function ($v) use ($currentQuarter, $currentYear) {
               $dt = Carbon::parse($this->resolveVisitDate($v));
               return $dt->quarter == $currentQuarter && $dt->year == $currentYear;
           });
   
           $previousQuarterVisits = $sorted->filter(function ($v) use ($previousQuarter, $previousYear) {
               $dt = Carbon::parse($this->resolveVisitDate($v));
               return $dt->quarter == $previousQuarter && $dt->year == $previousYear;
           });
   
           // 4. Compute averages
           $baseline = $previousQuarterVisits->avg('total_score');
           $current  = $currentQuarterVisits->avg('total_score');
   
           // If no previous quarter, baseline stays null
           if ($current === null) {
               // fallback: use latest score if nothing exists
               $current = $sorted->last()->total_score;
           }
   
           $change = ($current !== null && $baseline !== null)
               ? round($current - $baseline, 2)
               : null;
   
           $percent_change = ($baseline > 0)
               ? round((($current - $baseline) / $baseline) * 100, 2)
               : null;
   
           return (object) [
               'district'        => $district_name,
               'region'          => $visits->first()->region,
               'visits_count'    => $sorted->count(),
               'facilities'      => $sorted->pluck('facility_id')->unique()->count(),
   
               'baseline_score'  => $baseline !== null ? round($baseline * 5, 2) : null,
               'current_score'   => $current !== null ? round($current * 5, 2) : null,
               'change'          => $change !== null ? $change * 5 : null,
               'percent_change'  => $percent_change,
               'average_score'   => round($sorted->avg('total_score') * 5, 2),
               'trend_icon'      => ($change > 0 ? '▲' : ($change < 0 ? '▼' : '➝'))
           ];
           
        })->filter();
        
        /**
         * ---------- RANK BY CURRENT SCORE ----------
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
         * ---------- BASELINE RANK ----------
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
    private function paginateCollection($items)
    {
        $page = (int) ($this->facility_performance_table ?? 1);
        $perPage = (int) $this->perPage;
        $total = $items->count();
        $slice = $items->forPage($page, $perPage)->values();
        return new LengthAwarePaginator(
            $slice,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'facility_performance_table']
        );
    }    
    
    public function getBaselineCurrentTrendLast3Months($rows = null)
    {
        $threeMonthsAgo = now()->subMonths(3);

        if ($rows instanceof Collection) {
            $leagueData = $rows;
        } else {
            // load raw data
            $allScores = $this->loadAllScores();
            $scoreRows = $this->transformScoresToRows($allScores);
            $leagueData = $this->attachVisitMetaData($scoreRows);
        }

        // filter last 3 months only
        $last3Months = $leagueData->filter(function ($row) use ($threeMonthsAgo) {
            $createdAt = data_get($row, 'created_at');

            return $createdAt && Carbon::parse($createdAt)->greaterThanOrEqualTo($threeMonthsAgo);
        });

        // group by district for dashboard trend
        $district_grouped = $last3Months->filter(fn ($row) => !empty(data_get($row, 'district')))->groupBy('district');
        
        return $district_grouped->map(function ($visits, $district) {
            
            $sorted = $visits->sortBy('created_at')->values();
            
            if ($sorted->count() == 1) {
                $baseline = $sorted->first()->total_score;
                $current = $sorted->first()->total_score;
            } else {
                $baseline = $sorted->slice(0, $sorted->count() - 1)->avg('total_score');
                $current = $sorted->last()->total_score;
            }
            
            return [
                'district'        => $district,
                'baseline_score'  => round($baseline * 5, 2),
                'current_score'   => round($current * 5, 2),
                'current_date'    => $sorted->last()->date_of_visit,
                'change'          => round(($current - $baseline) * 5, 2),
                'percent_change'  => $baseline > 0 ? round((($current - $baseline) / $baseline) * 100, 2) : null,
            ];
        })->values();
        
    }

    private function resolveVisitDate($visit)
    {
        return data_get($visit, 'date_of_visit') ?? data_get($visit, 'created_at');
    }

    protected function getAvailableFilterYears(): Collection
    {
        $latestDate = $this->getLatestAvailableVisitDate();
        $earliestDate = FacilityVisit::query()->min('date_of_visit');
        $startYear = $latestDate->year;
        $endYear = $earliestDate ? Carbon::parse($earliestDate)->year : $startYear;

        if ($endYear > $startYear) {
            $endYear = $startYear;
        }

        return collect(range($startYear, $endYear));
    }

    protected function getQuarterOptions(): array
    {
        return [
            'q1' => 'Q1',
            'q2' => 'Q2',
            'q3' => 'Q3',
            'q4' => 'Q4',
        ];
    }

    protected function getDateFilterSummary(): ?string
    {
        if ($this->date_filter_type === 'quarterly') {
            $this->normalizeQuarterFilters();

            return 'Showing data for ' . strtoupper($this->filter_quarter) . ' ' . $this->filter_year . '.';
        }

        if (
            $this->date_filter_type === 'date_range'
            && !empty($this->from_date)
            && !empty($this->to_date)
        ) {
            return 'Showing data from ' . $this->from_date . ' to ' . $this->to_date . '.';
        }

        return null;
    }

    private function getLatestAvailableVisitDate(): Carbon
    {
        $latestVisitDate = FacilityVisit::query()->max('date_of_visit');

        return $latestVisitDate ? Carbon::parse($latestVisitDate) : Carbon::now();
    }

    private function normalizeQuarterFilters(): void
    {
        $fallbackDate = $this->getLatestAvailableVisitDate();
        $availableYears = $this->getAvailableFilterYears()->all();

        $year = $this->filter_year ? (int) $this->filter_year : $fallbackDate->year;
        $this->filter_year = in_array($year, $availableYears, true) ? $year : $fallbackDate->year;

        $quarterKey = is_string($this->filter_quarter) ? strtolower(trim($this->filter_quarter)) : '';
        $this->filter_quarter = in_array($quarterKey, ['q1', 'q2', 'q3', 'q4'], true)
            ? $quarterKey
            : 'q' . $fallbackDate->quarter;
    }

    private function resolveQuarterDates(string $quarterKey, int $year): array
    {
        $quarter = (int) str_replace('q', '', strtolower($quarterKey));
        $startMonth = (($quarter - 1) * 3) + 1;

        $startDate = Carbon::create($year, $startMonth, 1)->startOfDay();
        $endDate = (clone $startDate)->addMonths(2)->endOfMonth()->endOfDay();

        return [$startDate->toDateString(), $endDate->toDateString()];
    }

    private function resolveDateFilters(): array
    {
        if ($this->date_filter_type === 'quarterly') {
            $this->normalizeQuarterFilters();

            return $this->resolveQuarterDates($this->filter_quarter, (int) $this->filter_year);
        }

        if (
            $this->date_filter_type === 'date_range'
            && !empty($this->from_date)
            && !empty($this->to_date)
        ) {
            return [$this->from_date, $this->to_date];
        }

        return [null, null];
    }
    
    /**
     * ---------------------------------------------------------
     *  RETURN DISTRICT PERFORMANCE FOR MAP ( Choropleth )
     * ---------------------------------------------------------
    */
    
    public function getDistrictPerformance($rows = null)
    {
        if ($rows instanceof Collection) {
            return $rows
                ->filter(fn ($visit) => !empty(data_get($visit, 'district')))
                ->groupBy('district')
                ->map(function ($visits) {
                    return round($visits->avg('total_thematic') / 25 * 100, 2);
                })
                ->sortKeys()
                ->toArray();
        }

        // Build cache key based on filters
        $cacheKey = 'district_performance_' . md5(json_encode([
            $this->from_date,
            $this->to_date,
            $this->date_filter_type,
            $this->filter_year,
            $this->filter_quarter,
            $this->filter_region_id,
            $this->filter_district_id,
            $this->search,
        ]));
        
        // return Cache::remember($cacheKey, now()->addMinutes(30), function () {
            
            // Step 1: Load raw scores
            $scores = $this->loadAllScores();
            
            // Step 2: Convert all thematic area rows into visit rows
            $rows = $this->transformScoresToRows($scores);
            
            // Step 3: Attach facility metadata (district, region, etc.)
            $leagueData = $this->attachVisitMetaData($rows, $this->buildFilters());
            
            // Step 4: Group by district and compute average district score
            return $leagueData
            ->filter(fn ($v) => $v->district)   // ensure district exists
            ->groupBy('district')
            ->map(function ($visits) {
                
                // average of total_thematic per district
                return round($visits->avg('total_thematic')/25*100, 2);
            })
            ->sortKeys() // alphabetical district order
            ->toArray();
        // });
        
    }

    
    }
                
