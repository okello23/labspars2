<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Institution extends Model
{
    use HasFactory,LogsActivity,Notifiable;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Institutions')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $fillable = ['identifier', 'short_code', 'category', 'name',
        'contact', 'alt_contact', 'email', 'alt_email', 'country_id', 'tier',
        'level_id', 'region_served', 'is_active', 'address', 'is_training_partner',
        'contact_person_surname', 'contact_person_first_name', 'contact_person_other_name',
        'contact_person_email', 'contact_person_telephone', 'created_by'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(InstitutionProfile::class, 'institution_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
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

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('contact', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('category', 'like', '%'.$search.'%')
            ->orWhere('identifier', 'like', '%'.$search.'%')
            ->orWhere('short_code', 'like', '%'.$search.'%')
            ->orWhere('contact_person_surname', 'like', '%'.$search.'%')
            ->orWhere('contact_person_first_name', 'like', '%'.$search.'%')
            ->orWhere('contact_person_other_name', 'like', '%'.$search.'%')
            ->orWhere('contact_person_email', 'like', '%'.$search.'%')
            ->orWhere('contact_person_telephone', 'like', '%'.$search.'%')
            ->orWhere('address', 'like', '%'.$search.'%')
            ->orWhere('tier', 'like', '%'.$search.'%');
    }
}
