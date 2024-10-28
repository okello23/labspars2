<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvOrderReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'quantity_ordered',
        'quantity_received',
        'fulfillment_rate',
        'visit_id',
        'review_percentage',
        'review_score',
    ];
}
