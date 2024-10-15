<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvAdherence extends Model
{
    use HasFactory;
    protected $fillable =[
        'ordering_schedule_deadline', 
        'actual_ordering_date',
        'ordering_timely',
        'delivery_schedule_deadline',
        'delivery_date', 
        'delivery_on_time', 
        'adherence_comments', 
        'adherence_score', 
        'adherence_percentage', 
        'annual_procurement_plan',
        'procurement_plan_comments',
        'visit_id'
    ];
}
