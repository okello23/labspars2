<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvCleanlinessManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'lab_store_clean',
        'main_store_clean',
        'laboratory_clean',
        'cleanliness_comments',
    ];
}
