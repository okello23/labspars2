<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistrictLeagueExport implements FromCollection, WithHeadings
{
    protected Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'District',
            'Region',
            'Baseline Score',
            'Baseline Rank',
            'Change',
            '% Change',
            'Current Score',
            'Current Rank',
            'Average Score',
            'Facilities',
            'Total Visits',
        ];
    }
    
    public function collection()
    {
        return $this->data->map(function ($row) {
            return [
                $row['district'] ?? '',
                $row['region'] ?? '',
                $row['baseline_score'] ?? '',
                $row['baseline_rank'] ?? '',
                $row['change'] ?? '',
                $row['percent_change'].'%' ?? '',
                $row['current_score'] ?? '',
                $row['rank'] ?? '',
                $row['average_score'] ?? '',
                $row['facilities'] ?? '',
                $row['visits_count'] ?? '',
            ];
        });
    }
}
