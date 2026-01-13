<?php
namespace App\Http\Livewire\Dashboard;

use App\Models\District;
use App\Traits\LeagueDataTrait;
use App\Models\Facility\Facility;
use App\Models\Facility\FacilityVisit;
use App\Models\Facility\Visits\FvStockManagement;
use App\Models\Settings\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockStatusDashboardComponent extends Component
{
    use WithPagination;
    use LeagueDataTrait;

    public $perPage          = 10;
    public $search           = '';
    public $orderBy          = 'id';
    public $orderAsc         = 0;
    public $selectedRegion   = null;
    public $selectedDistrict = null;
    public $dateRange        = 'all';
    public $customStartDate  = null;
    public $customEndDate    = null;
    public $type;
    
    public $scoreSets = [
        [
            'label' => 'Visit-1 Score:',
            'data' => [3.2, 2.7, 4, 4.5, 5],
            'color' => 'rgb(255, 169, 99,1)'
        ],
        [
            'label' => 'Visit-2 Score:',
            'data' => [4.0, 3.5, 4.2, 4.8, 4.7],
            'color' => 'rgba(54, 162, 235, 1)'
        ],
        [
            'label' => 'Visit-3 Score:',
            'data' => [4.5, 4.0, 4.6, 5.0, 4.9],
            'color' => 'rgba(75, 192, 192, 1)'
        ]
    ];
    
    protected $queryString = [
        'search'           => ['except' => ''],
        'dateRange'        => ['except' => 'all'],
        'selectedRegion'   => ['except' => null],
        'selectedDistrict' => ['except' => null],
        'type'             => ['except' => null],
    ];

    private function randomColor($index)
    {
        $colors = [
            'rgb(255, 169, 99, 1)',      // Visit-1: orange
            'rgba(54, 162, 235, 1)',     // Visit-2: blue
            'rgba(75, 192, 192, 1)',     // Visit-3: teal
            'rgba(153, 102, 255, 1)',    // purple
            'rgba(255, 206, 86, 1)',     // yellow
            'rgba(201, 203, 207, 1)',    // grey
            'rgba(255, 99, 132, 1)',     // red
            'rgba(0, 128, 128, 1)',      // dark teal
            'rgba(0, 191, 255, 1)',      // deep sky blue
            'rgba(255, 105, 180, 1)',    // hot pink
        ];
        
        return $colors[$index % count($colors)];
    }

    public function mount(){

    }

    public function refresh(){
        return redirect(request()->header('Referer'));
    }

    public function query(){
        $user = \Auth()->user();
        $data = FvStockManagement::query()
        ->with(['facility.healthSubDistrict.district.region']);
        
        // Filter for user's Institution if no region/district is selected
        if ($user->category === 'Institution' && !$this->selectedRegion && !$this->selectedDistrict) {
            $data->whereHas('facility', function ($q) use ($user) {
                $q->where('facility_id', $user->facility_id);
                });
            }
            
            // Existing filters
            if ($this->selectedRegion) {
                $data->whereHas('facility.healthSubDistrict.district', function ($q) {
                    $q->where('region_id', $this->selectedRegion);
                    });
            }
            
            if ($this->selectedDistrict) {
                $data->whereHas('facility.healthSubDistrict', function ($q) {
                    $q->where('district_id', $this->selectedDistrict);
                    });
            }
            
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
    public function updatedDateRange(){
        $this->loadDashboardData();
    }
    
    public function updatedSelectedRegion(){
        $this->selectedDistrict = null;
        $this->loadDashboardData();
    }

    public function updatedSelectedDistrict(){
        $this->loadDashboardData();
    }
    
    public function render(){
        $regions   = Region::all();
        $stock_status = FvStockManagement::get();
        
        $districts = $this->selectedRegion
        ? District::where('region_id', $this->selectedRegion)->get()
        : collect();
        
        $grouped_stock = $stock_status->groupBy(function ($item) {
            return $item->visit->facility->id;
        });
        
        return view('livewire.dashboard.stock-status-dashboard-component', [
            'regions'        => $regions,
            'districts'      => $districts,
            'grouped_stock'  => $grouped_stock,
            ]);
    }
}