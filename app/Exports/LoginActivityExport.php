<?php

namespace App\Exports;

use App\Models\LoginRecord;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LoginActivityExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $loginRecordIds;

    public function __construct(array $loginRecordIds)
    {
        $this->count = 0;
        $this->loginRecordIds = $loginRecordIds;
    }

    public function collection()
    {
        return LoginRecord::whereIn('id', $this->loginRecordIds)->latest()->get();
    }

    public function map($log): array
    {
        $this->count++;

        return [
            $this->count,
            $log->email ?? 'N/A',
            $log->description ?? 'N/A',
            $log->platform ?? 'N/A',
            $log->browser ?? 'N/A',
            $log->client_ip ?? 'N/A',
            $log->created_at ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Email',
            'Activity',
            'Platform',
            'Browser',
            'IP Address',
            'Date/Time',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
