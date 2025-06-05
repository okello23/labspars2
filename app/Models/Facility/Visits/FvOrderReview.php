<?php

namespace App\Models\Facility\Visits;

use App\Models\Settings\Reagent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'order_item_id'
    ];
    public function reagent()
    {
        return $this->belongsTo(Reagent::class, 'order_item_id', 'id');
    }
}
