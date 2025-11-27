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
            'Current Score',
            'Change',
            '% Change',
            'Average Score',
            'Facilities',
            'Total Visits',
            'Rank',
        ];
    }

    public function collection()
    {
        return $this->data->map(function ($row) {
            return [
                $row->district,
                $row->region,
                $row->baseline_score,
                $row->current_score,
                $row->change,
                $row->percent_change,
                $row->average_score,
                $row->facilities,
                $row->visits_count,
                $row->rank,
            ];
        });
    }
}
