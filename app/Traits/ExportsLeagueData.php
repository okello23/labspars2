<?php

namespace App\Traits;

use Maatwebsite\Excel\Facades\Excel;

trait ExportsLeagueData
{
    protected function exportToExcel($exportClass, $fileName)
    {
        return Excel::download(new $exportClass, $fileName);
    }
}
