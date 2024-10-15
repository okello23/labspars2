<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvEquipmentUtilization extends Model
{
    use HasFactory;
    protected $fillable=[
        'equipment_id',
        'equipment_name',
        'equipment_type',
        'through_put', 
        'running_days', 
        'actual_output', 
        'expected_output',
        'utilization', 
        'greater_score', 
        'capacity', 
        'final_score', 
        'visit_id'
   ];
}
