<?php

namespace App\Models\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'description',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(Region::class, 'created_at', 'id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
}
