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
            'Stock Management',
            'Storage',
            'Ordering',
            'Equipment',
            'LIS',
            'Spider Graph Value (Scaled)',
            'Total Spider Score (Max =25)',
            'Overall Score (%)',
            'Date of Visit',
            'Date Entered',
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($row) {
            return [
                $row['facility']['name'].' '.$row['facility']['level']  ?? '',
                $row['district'] ?? '',
                $row['region'] ?? '',
                $row['stock_management'] ?? '',
                $row['storage_management'] ?? '',
                $row['ordering_management'] ?? '',
                $row['equipment_management'] ?? '',
                $row['lis_mgt'] ?? '',
                $row['total_score'] ?? '',
                $row['total_thematic'] ?? '',
                ($row['total_thematic']/25)*100 . '%' ?? '',
                $row['date_of_visit'] ?? '',
                $row['created_at'] ?? '',
            ];
        });
    }
}
