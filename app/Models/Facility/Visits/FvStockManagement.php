<?php

namespace App\Models\Facility\Visits;

use App\Models\Settings\Reagent;
use App\Models\Facility\FacilityVisit;
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

    public function visit()
    {
        return $this->belongsTo(FacilityVisit::class, 'visit_id', 'id');
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

    public function scopeFilterSearch($query, $searchTerm)
    {
    if ($searchTerm) {
        $query->where(function ($q) use ($searchTerm) {
            $q->whereHas('reagent', function ($sub) use ($searchTerm) {
                $sub->where('name', 'like', '%'.$searchTerm.'%');
            })
            ->orWhereHas('visit.facility', function ($sub) use ($searchTerm) {
                $sub->where('name', 'like', '%'.$searchTerm.'%');
            });
        });
    }

    return $query;
}
}