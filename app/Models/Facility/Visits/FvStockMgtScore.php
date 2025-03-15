<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvStockMgtScore extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_id',
        'availability_score',
        'availability_percentage',
        'stock_card_score',
        'stock_card_percentage',
        'correct_filling_score',
        'correct_filling_percentage',
        'physical_agrees_score',
        'physical_agrees_percentage',
        'amc_well_calculated_score',
        'amc_well_calculated_percentage',
        'emr_usage_score',
        'emr_usage_percentage',
        'stock_mgt_comments',
    ];

}
