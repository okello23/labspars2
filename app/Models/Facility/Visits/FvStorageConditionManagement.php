<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvStorageConditionManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'main_store_expired_record',
        'lab_store_expired_record',
        'main_store_expired_separate',
        'lab_store_expired_separate',
        'main_store_fefo',
        'lab_store_fefo',
        'main_store_opening_date',
        'lab_store_opening_date',
        'practices_comments',
        'condition_comments'
    ];
}
