<?php
namespace App\Http\Livewire\Dashboard;

use App\Models\District;
use App\Traits\LeagueDataTrait;
use App\Models\Facility\Facility;
use App\Models\Facility\FacilityVisit;
use App\Models\Facility\Visits\FvStockManagement;
use App\Models\Settings\Region;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StockStatusDashboardComponent extends Component
{
    use WithPagination;
    use LeagueDataTrait;

    protected $paginationTheme = 'bootstrap';

    public $perPage          = 10;
    public $search           = '';
    public $orderBy          = 'id';
    public $orderAsc         = 0;
    public $selectedRegion   = null;
    public $selectedDistrict = null;
    public $dateRange        = 'quarter';
    public $filterYear;
    public $filterQuarter;
    public $customStartDate  = null;
    public $customEndDate    = null;
    public $exportIds;
    public $type;
    public $districts_list = [];
    public $filter_region_id;
    public $filter_district_id;
    public $districtSearch = '';
    public $quarterNotice;
    
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
        ],#metro34
        [
            'label' => 'Visit-3 Score:',
            'data' => [4.5, 4.0, 4.6, 5.0, 4.9],
            'color' => 'rgba(75, 192, 192, 1)'
        ]
    ];
    
    protected $queryString = [
        'search'           => ['except' => ''],
        'dateRange'        => ['except' => 'quarter'],
        'filterYear'       => ['except' => null],
        'filterQuarter'    => ['except' => null],
        'filter_region_id' => ['except' => null],
        'filter_district_id' => ['except' => null],
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

    public function mount()
    {
        $this->dateRange = in_array($this->dateRange, ['quarter', 'custom'], true) ? $this->dateRange : 'quarter';
        $this->filterYear = $this->filterYear ?: Carbon::now()->year;
        $this->filterQuarter = $this->filterQuarter ?: $this->getCurrentQuarterKey();
        $this->districts_list = $this->loadDistricts($this->filter_region_id);
        $this->syncDistrictSearchFromSelection();
        $this->updateQuarterNotice();
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
    }

    public function updatedFilterRegionId($value)
    {
        $this->resetPage();
        $this->filter_district_id = null;
        $this->districtSearch = '';
        $this->districts_list = $this->loadDistricts($value);
    }

    public function updatingFilterDistrictId()
    {
        $this->resetPage();
    }

    public function updatedFilterDistrictId()
    {
        $this->syncDistrictSearchFromSelection();
    }

    public function updatedDistrictSearch($value)
    {
        $this->resetPage();

        if (blank($value)) {
            $this->filter_district_id = null;
            return;
        }

        $district = $this->districts_list->first(function ($item) use ($value) {
            return strcasecmp($item->name, trim($value)) === 0;
        });

        $this->filter_district_id = $district?->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
    {
        $this->resetPage();
    }

    public function updatingCustomStartDate()
    {
        $this->resetPage();
    }

    public function updatingCustomEndDate()
    {
        $this->resetPage();
    }
    
  
     public function mainQuery()
    {
      $stock = FvStockManagement::query()
            ->filterSearch($this->search)
            ->with(['visit.facility.healthSubDistrict.district.region', 'reagent'])
            ->when($this->filter_region_id, function ($query) {
                $query->whereHas('visit.facility.healthSubDistrict.district', function ($q) {
                    $q->where('region_id', $this->filter_region_id);
                });
            })
            ->when($this->filter_district_id, function ($query) {
                $query->whereHas('visit.facility.healthSubDistrict', function ($q) {
                    $q->where('district_id', $this->filter_district_id);
                });
            })
            ->when($this->dateRange === 'custom' && $this->customStartDate && $this->customEndDate, function ($query) {
                $query->whereBetween('created_at', [$this->customStartDate, $this->customEndDate]);
            })
            ->when($this->type, function ($query) {
                if ($this->type === 'performing') {
                    $query->where('test_performed', true);
                } elseif ($this->type === 'non-performing') {
                    $query->where('test_performed', false);
                }
            })
            ->when($this->dateRange === 'quarter', function ($query) {
                [$startDate, $endDate] = $this->resolveQuarterDates($this->filterQuarter, (int) $this->filterYear);

                $query->whereBetween('created_at', [$startDate, $endDate]);
            });

        return $stock;
    }

    private function getCurrentQuarterKey(): string
    {
        return 'q' . Carbon::now()->quarter;
    }

    private function resolveQuarterDates(string $quarterKey, int $year): array
    {
        $quarter = (int) str_replace('q', '', strtolower($quarterKey));
        $startMonth = (($quarter - 1) * 3) + 1;

        $startDate = Carbon::create($year, $startMonth, 1)->startOfDay();
        $endDate = (clone $startDate)->addMonths(2)->endOfMonth()->endOfDay();

        return [$startDate, $endDate];
    }

    private function updateQuarterNotice(): void
    {
        $this->quarterNotice = 'Data loaded is for the current quarter (' . strtoupper($this->filterQuarter) . ' ' . $this->filterYear . '). To view past data, use the filters.';
    }

    private function loadDistricts($regionId)
    {
        if (!$regionId) {
            return collect();
        }

        return District::where('region_id', $regionId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function syncDistrictSearchFromSelection(): void
    {
        if (!$this->filter_district_id) {
            $this->districtSearch = '';
            return;
        }

        $district = $this->districts_list->firstWhere('id', $this->filter_district_id);
        $this->districtSearch = $district?->name ?? '';
    }

    public function updatingFilterYear()
    {
        $this->resetPage();
    }

    public function updatedFilterYear()
    {
        $this->updateQuarterNotice();
    }

    public function updatingFilterQuarter()
    {
        $this->resetPage();
    }

    public function updatedFilterQuarter()
    {
        $this->updateQuarterNotice();
    }

    public function updatedDateRange()
    {
        $this->resetPage();

        if ($this->dateRange === 'quarter') {
            $this->updateQuarterNotice();
            return;
        }

        $this->quarterNotice = 'Select a start date and end date to view stock status for a custom period.';
    }

    private function paginateGroupedStock($groupedStock): LengthAwarePaginator
    {
        $page = $this->page ?: 1;
        $items = $groupedStock->values();
        $paginatedItems = $items->forPage($page, $this->perPage)->values();

        return new LengthAwarePaginator(
            $paginatedItems,
            $items->count(),
            (int) $this->perPage,
            (int) $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }


  public function render()
    {
         $stock_status = $this->mainQuery()->get();
         
         $grouped_stock = $stock_status->groupBy(function ($item) {
             return $item->visit->facility->id ?? 'unknown';
         });

         $paginatedGroupedStock = $this->paginateGroupedStock($grouped_stock);


        $regions = Region::orderBy('name')->get();
        $years = collect(range(Carbon::now()->year, Carbon::now()->year - 5))->values();

        return view('livewire.dashboard.stock-status-dashboard-component', [
            'grouped_stock'    => $paginatedGroupedStock,
            'regions'         => $regions,
            'years'           => $years,
        ])->layout('layouts.app');
    }

}
