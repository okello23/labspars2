<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;
use App\Traits\LeagueDataTrait; 
use App\Models\Settings\Region;
use App\Traits\ExportsLeagueData; 
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Exports\FacilityPerformanceExport;
use Illuminate\Pagination\LengthAwarePaginator;

class FacilityPerformanceComponent extends Component
{
    use WithPagination;
    use LeagueDataTrait;  
    use ExportsLeagueData;
    public $lss_data;

    public function export()
    {
        return $this->exportToExcel(
            new FacilityPerformanceExport(collect($this->lss_data)), "lss_facility_performance_summary.xlsx"
        );
    }

    public function render()
    {
        $this->lss_data = $this->prepareLeagueData();
        
        $data = [
            'facility_performance' => $this->paginateCollection(
                $this->rankFacilities($this->lss_data)
            ),
            'regions'              => Region::all(),
            'health_sub_districts' => [],
        ];

        return view('livewire.reports.facility-performance-component', $data);
    }
}