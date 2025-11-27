<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use App\Models\Settings\Region;
use Illuminate\Support\Collection;
use App\Models\District;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Traits\LeagueDataTrait; 
use Livewire\WithPagination;

class FacilityPerformanceComponent extends Component
{
    use WithPagination;
     use LeagueDataTrait;

    public function render()
    {
        $leagueData = $this->prepareLeagueData();
        
        $data = [
            'facility_performance' => $this->paginateCollection(
                $this->rankFacilities($leagueData)
            ),
            'regions'              => Region::all(),
            'health_sub_districts' => [],
        ];
        
        return view('livewire.reports.facility-performance-component', $data);
    }
}

