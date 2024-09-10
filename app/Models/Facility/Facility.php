<?php

namespace App\Models\Facility;

use App\Models\District;
use App\Models\Settings\County;
use App\Models\Settings\Parish;
use App\Models\Settings\Village;
use App\Models\Settings\SubCounty;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory ,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Facilities')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
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
    protected $fillable = [
            'name',
            'level',
            'ownership',
            'sub_district_id',
    ];

    public function district()
    {
      return $this->belongsTo(District::class, 'district_id', 'id');
    }



    public function parish()
    {
        return $this->belongsTo(Parish::class, 'parish_id', 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }



    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%');
    }
}
