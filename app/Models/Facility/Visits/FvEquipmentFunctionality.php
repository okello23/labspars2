<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvEquipmentFunctionality extends Model
{
    use HasFactory;
    protected $fillable=[
         'equipment_id',
         'equipment_name',
         'equipment_type',
         'functional',
         'downtime',
         'nonfunctional_hw',
         'nonfunctional_reagents',
         'other_factors',
         'response_time',
         'visit_id'
    ];
}
