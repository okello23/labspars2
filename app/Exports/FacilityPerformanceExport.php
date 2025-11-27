<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacilityPerformanceExport implements FromCollection, WithHeadings
{
    protected Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Facility Name',
            'District',
            'Region',
            'Score',
            'Rank',
            'Total Visits',
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($row) {
            return [
                $row->facility_name,
                $row->district,
                $row->region,
                $row->total_thematic,
                $row->rank,
                $row->visits_count,
            ];
        });
    }
}
