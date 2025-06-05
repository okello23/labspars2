<?php

namespace App\Exports;

use App\Models\dhis2Reports\Dhis233bReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Export33bReports implements FromCollection, WithHeadings, WithMapping
{
    public $exportIds;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(array $exportData)
    {
        $this->exportIds = $exportData;
    }

    public function collection()
    {
        return Dhis233bReport::with('facility')->whereIn('id', $this->exportIds)->get();
    }

    public function map($report): array
    {
        return [
            $report->facility->facility_name,
            $report->facility->district->name,
            $report->dataElement,
            $report->value,
            $report->period,
        ];
    }

    public function headings(): array
    {
        return [
            'Health Facility',
            'District',
            'Data Element',
            'Value',
            'Period',
        ];
    }
}
