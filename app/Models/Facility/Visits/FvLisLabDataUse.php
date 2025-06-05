<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvLisLabDataUse extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_id',
        'item_name',
        'updated_last_quarter',
        'is_available',
        'comments',
    ];
}
