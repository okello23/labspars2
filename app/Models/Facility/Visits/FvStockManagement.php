<?php

namespace App\Models\Facility\Visits;

use App\Models\Settings\Reagent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FvStockManagement extends Model
{
    use HasFactory;
    protected $fillable =[
        'visit_id',
        'reagent_id',
        'test_performed',
        'item_available',
        'stock_card_available',
        'physical_count_done',
        'stock_card_correct',
        'balance_on_card',
        'physical_count',
        'balance_matches_physical',
        'last_issues',
        'out_of_stock_days',
        'amc_on_card',
        'amc_calculated',
        'amc_calculated_matches',
        'elmis_installed',
        'elmis_quantity',
        'elmis_balance_matches',
    ];

    public function reagent()
    {
        return $this->belongsTo(Reagent::class, 'reagent_id', 'id');
    }
    
    public static function boot()
    {
        parent::boot();

        if (Auth::check()) {
            self::creating(function ($model) {
                // Set created_by attribute
                $model->created_by = auth()->id();
            });
        }
    }
}
