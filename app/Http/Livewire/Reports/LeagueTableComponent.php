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
use App\Exports\DistrictLeagueExport;
use Illuminate\Pagination\LengthAwarePaginator;

class LeagueTableComponent extends Component
{
    use WithPagination;
    use LeagueDataTrait;
    use ExportsLeagueData;
    public $export_data;   

    public function export()
    {
        return $this->exportToExcel(
            new DistrictLeagueExport(collect($this->export_data)), "district_league.xlsx"
        );
    }


    public function render()
    {
        $leagueData = $this->prepareLeagueData();
        
        $data = [
            'regions'              => Region::all(),
            'health_sub_districts' => [],
            'district_performance' => $this->computeDistrictLeague($leagueData),
        ];
        $this->export_data = $data['district_performance'];

        return view('livewire.reports.league-table-component', $data);
    }
}