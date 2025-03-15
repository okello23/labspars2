<?php

namespace App\Imports\Management;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NonAMRImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        //
    }
}
