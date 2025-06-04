<?php
namespace App\Http\Livewire\Dashboard;

use App\Models\District;
use App\Models\Facility\Facility;
use App\Models\Facility\FacilityVisit;
use App\Models\Settings\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MainDashboardComponent extends Component
{
    use WithPagination;

    public $perPage          = 10;
    public $search           = '';
    public $orderBy          = 'id';
    public $orderAsc         = 0;
    public $selectedRegion   = null;
    public $selectedDistrict = null;
    public $dateRange        = 'all';
    public $customStartDate  = null;
    public $customEndDate    = null;

    // Statistics holders
    public $totalVisits       = 0;
    public $pendingVisits     = 0;
    public $completedVisits   = 0;
    public $visitsByStatus    = [];
    public $visitTrends       = [];
    public $regionWiseStats   = [];
    public $equipmentStats    = [];
    public $stockStats        = [];
    public $adherenceScores   = [];
    public $storageConditions = [];
    public $facilityStats     = [];

    protected $queryString = [
        'search'           => ['except' => ''],
        'dateRange'        => ['except' => 'all'],
        'selectedRegion'   => ['except' => null],
        'selectedDistrict' => ['except' => null],
    ];

    public function mount()
    {
        $this->loadDashboardData();
    }
    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }
    public function query()
    {
        $data = FacilityVisit::query()
            ->with(['facility.healthSubDistrict.district.region'])

            ->when($this->selectedRegion, function ($query) {
                $query->whereHas('facility.healthSubDistrict.district', function ($q) {
                    $q->where('region_id', $this->selectedRegion);
                });
            })

            ->when($this->selectedDistrict, function ($query) {
                $query->whereHas('facility.healthSubDistrict', function ($q) {
                    $q->where('district_id', $this->selectedDistrict);
                });
            });
        // Apply date filters
        switch ($this->dateRange) {
            case 'today':
                $data->whereDate('date_of_visit', Carbon::today());
                break;
            case 'week':
                $data->whereBetween('date_of_visit', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $data->whereBetween('date_of_visit', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'custom':
                if ($this->customStartDate && $this->customEndDate) {
                    $data->whereBetween('date_of_visit', [$this->customStartDate, $this->customEndDate]);
                }
                break;
        }
        return $data;
        // Region and District filters

    }
    public function loadDashboardData()
    {

        // Basic Statistics
        $this->totalVisits     = $this->query()->count();
        $this->pendingVisits   = $this->query()->where('status', 'Pending')->count();
        $this->completedVisits = $this->query()->where('status', 'Approved')->count();

        // Visit Status Distribution
        $this->visitsByStatus = $this->query()->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Region-wise Statistics
        $this->regionWiseStats = $this->query()->select('regions.name', DB::raw('count(*) as visits'))
            ->join('facilities', 'facility_visits.facility_id', '=', 'facilities.id')
            ->join('health_sub_districts', 'facilities.sub_district_id', '=', 'health_sub_districts.id')
            ->join('districts', 'health_sub_districts.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->groupBy('regions.name')
            ->get();

        // Equipment Functionality Statistics
        $this->equipmentStats = DB::table('fv_equipment_functionalities')
            ->select('equipment_type', DB::raw('count(*) as count'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->groupBy('equipment_type')
            ->get();

        // Stock Management Scores (Fixed)
        $this->stockStats = DB::table('fv_stock_mgt_scores')
            ->select(DB::raw('AVG(availability_score) as average_score'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->first()
            ->average_score ?? 0;

        // Visit Trends (Last 12 months)
        $this->visitTrends = $this->query()
            ->selectRaw('count(*) as count')
            ->selectRaw("DATE_FORMAT(date_of_visit, '%M-%Y') month")
            ->selectRaw("DATE_FORMAT(date_of_visit, '%Y-%m') new_date")
            ->where('date_of_visit', '>=', Carbon::now()->subMonths(12))
            ->groupBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->orderBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->get();

        // Facility Statistics
        $this->facilityStats = [
            'total'   => Facility::count(),
            'visited' => $this->query()->distinct('facility_id')->count('facility_id'),
            'active'  => Facility::where('is_active', true)->count(),
        ];
    }
    public function loadDashboardData3()
    {
        $query = FacilityVisit::query()
            ->with(['facility.healthSubDistrict.district.region']);

        // Apply date filters
        switch ($this->dateRange) {
            case 'today':
                $this->query()->whereDate('date_of_visit', Carbon::today());
                break;
            case 'week':
                $this->query()->whereBetween('date_of_visit', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $this->query()->whereBetween('date_of_visit', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'custom':
                if ($this->customStartDate && $this->customEndDate) {
                    $this->query()->whereBetween('date_of_visit', [$this->customStartDate, $this->customEndDate]);
                }
                break;
        }

        // Region and District filters
        if ($this->selectedRegion) {
            $this->query()->whereHas('facility.healthSubDistrict.district', function ($q) {
                $q->where('region_id', $this->selectedRegion);
            });
        }

        if ($this->selectedDistrict) {
            $this->query()->whereHas('facility.healthSubDistrict', function ($q) {
                $q->where('district_id', $this->selectedDistrict);
            });
        }

        // Basic Statistics
        $this->totalVisits     = $this->query()->count();
        $this->pendingVisits   = $this->query()->where('status', 'Pending')->count();
        $this->completedVisits = $this->query()->where('status', 'Approved')->count();

        // Visit Status Distribution
        $this->visitsByStatus = $this->query()->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Region-wise Statistics
        $this->regionWiseStats = $this->query()->select('regions.name', DB::raw('count(*) as visits'))
            ->join('facilities', 'facility_visits.facility_id', '=', 'facilities.id')
            ->join('health_sub_districts', 'facilities.sub_district_id', '=', 'health_sub_districts.id')
            ->join('districts', 'health_sub_districts.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->groupBy('regions.name')
            ->get();

        // Equipment Functionality Statistics
        $this->equipmentStats = DB::table('fv_equipment_functionalities')
            ->select('equipment_type', DB::raw('count(*) as count'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->groupBy('equipment_type')
            ->get();

        // Stock Management Scores
        $this->stockStats = DB::table('fv_stock_mgt_scores')
            ->select(DB::raw('AVG(availability_score) as average_score'))
            ->whereIn('visit_id', $this->query()->pluck('id'))
            ->first();

        // Visit Trends (Last 12 months)

        $this->visitTrends = $query
            ->selectRaw('count(*) as count')
            ->selectRaw("DATE_FORMAT(date_of_visit, '%M-%Y') month")
            ->selectRaw("DATE_FORMAT(date_of_visit, '%Y-%m') new_date")
            ->where('date_of_visit', '>=', Carbon::now()->subMonths(12))
            ->groupBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->orderBy(DB::raw("DATE_FORMAT(date_of_visit, '%M-%Y')"))
            ->get();

        // Facility Statistics
        $this->facilityStats = [
            'total'   => Facility::count(),
            'visited' => $this->query()->distinct('facility_id')->count('facility_id'),
            'active'  => Facility::where('is_active', true)->count(),
        ];
    }

    public function updatedDateRange()
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedRegion()
    {
        $this->selectedDistrict = null;
        $this->loadDashboardData();
    }

    public function updatedSelectedDistrict()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        $regions   = Region::all();
        $districts = $this->selectedRegion ? District::where('region_id', $this->selectedRegion)->get() : collect();

        return view('livewire.dashboard.main-dashboard-component', [
            'regions'   => $regions,
            'districts' => $districts,
        ]);
    }
}
