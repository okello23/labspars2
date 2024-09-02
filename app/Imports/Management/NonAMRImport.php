<?php

namespace App\Imports\Management;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NonAMRImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
