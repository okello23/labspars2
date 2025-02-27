<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvHygieneManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'running_water',
        'hand_washing_separate',
        'hand_washing_facility',
        'drainage_system',
        'soap_available',
        'hygiene_comments',
    ];
}
