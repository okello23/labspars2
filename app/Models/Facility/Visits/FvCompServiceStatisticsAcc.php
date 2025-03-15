<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvCompServiceStatisticsAcc extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'visit_id',
        'service_name',                     
        'service_statistics_available',
        'hims_tests_reported',
        'lab_reg_tests_reported',
        'hims_lab_tests_balance',
    ];

}
