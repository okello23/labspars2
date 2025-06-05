<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvOrderManagement extends Model
{
    use HasFactory;
    protected $fillable=[
        'cycles_filed_comments',
        'cycles_filed_stored',
        'electronic_submission',
        'electronic_submission_comments',
        'soh',
        'quantity_issued',
        'days_out_of_stock',
        'adjusted_amc',
        'max_quantity',
        'quantity_to_order',
        'test_menu_available',
        'annual_procurement_plan',
        'procurement_plan_comments',
        'adherence_percentage',
        'adherence_score',
        'qty_to_order_score',
        'visit_id'
    ];
}
