<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithProperties
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $userIds;

    public function __construct(array $userIds)
    {
        $this->count = 0;
        $this->userIds = $userIds;
    }

    public function properties(): array
    {
        return [
            'creator' => auth()->user()->fullName,
            'lastModifiedBy' => 'MERP',
            'title' => 'Users',
            'description' => 'Users export',
            'subject' => 'Users export',
            'keywords' => 'MERP exports',
            'category' => 'MERP Exports',
            'manager' => 'MERP',
            'company' => 'MERP',
        ];
    }

    public function collection()
    {
        return User::whereIn('id', $this->userIds)->latest()->get();
    }

    public function map($user): array
    {
        $this->count++;

        return [
            $this->count,
            $user->fullName,
            $user->name,
            $user->email ?? 'N/A',
            $user->contact ?? 'N/A',
            $user->is_active === 1 ? 'Active' : 'Suspended',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Username',
            'Email',
            'Contact',
            'Status',
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
