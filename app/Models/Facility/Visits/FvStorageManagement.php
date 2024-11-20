<?php

namespace App\Models\Facility\Visits;

use App\Models\Facility\FvStorageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FvStorageManagement extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Storage management')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $fillable = [
        'visit_id',
        'other',
        'comment',
        'storage_type_id',
    ];

    public function storageType()
    {
        return $this->belongsTo(FvStorageType::class, 'storage_type_id', 'id');
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
}
