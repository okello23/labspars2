<?php

namespace App\Traits;

use App\Exports\DistrictLeagueExport;
use Maatwebsite\Excel\Facades\Excel;


trait ExportsLeagueData
{

    protected function exportToExcel($export)
    {
        return Excel::download($export, 'district_league.xlsx');
    }
}

