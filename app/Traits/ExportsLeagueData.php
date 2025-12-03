<?php

namespace App\Traits;

use App\Exports\DistrictLeagueExport;
use Maatwebsite\Excel\Facades\Excel;


trait ExportsLeagueData
{

    protected function exportToExcel($exportClass, $fileName)
    {
        return Excel::download($exportClass, $fileName);
    }
}

