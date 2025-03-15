<?php

namespace App\Models\Facility;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FacilityVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_number',
        'in_charge_name',
        'in_charge_contact',
        'responsible_lss_name',
        'facility_id',
        'use_stock_cards',
        'date_of_visit',
        'date_of_next_visit',
        'consumption_reconciliation',
        'use_stock_cards',
        'stage',
        'status',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
            self::updating(function ($model) {
                $model->updated_by = auth()->id();
            });

        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('visit_number', 'like', '%'.$search.'%');
    }
}
