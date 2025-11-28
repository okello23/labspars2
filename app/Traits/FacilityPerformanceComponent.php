<?php

namespace App\Traits;

use App\Traits\ExportsLeagueData;
use App\Exports\FacilityPerformanceExport;

class FacilityPerformanceComponent extends Component
{
    use ExportsLeagueData;

    public function exportFacilityPerformance()
    {
        return $this->exportToExcel(
            new FacilityPerformanceExport($this->facilityData),
            "facility_performance.xlsx"
        );
    }
}
