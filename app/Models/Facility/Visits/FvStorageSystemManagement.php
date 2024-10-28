<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvStorageSystemManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'main_store_shelves',
        'lab_store_shelves',
        'main_store_reagents',
        'lab_store_reagents',
        'main_store_stock_cards',
        'lab_store_stock_cards',
        'main_store_systematic',
        'lab_store_systematic',
        'main_store_labeled',
        'lab_store_labeled',
        'storage_comments',
    ];
}
