<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use App\Models\Institution;
use App\Models\Facility\Facility;
use App\Models\TrainingManagement\Nominee;
use App\Models\TrainingManagement\Trainer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laratrust\Traits\LaratrustUserTrait;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
  use LaratrustUserTrait;
  use HasApiTokens, HasFactory, Notifiable,LogsActivity,CausesActivity;

  public function getActivitylogOptions(): LogOptions
  {
    return LogOptions::defaults()
    ->logOnly(['*'])
    ->logFillable()
    ->useLogName('Users')
    ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
    ->logOnlyDirty()
    ->dontSubmitEmptyLogs();
    // Chain fluent methods for configuration options
  }

  /**
  * The attributes that are mass assignable.
  *\Auth::user()->actions;
  *
  * @var array<int, string>
  */
  protected $fillable = [
    'employee_id',
    'emp_id',
    'surname',
    'first_name',
    'other_name',
    'name',
    'category',
    'email',
    'password',
    'password_updated_at',
    'contact',
    'title',
    'avatar',
    'signature',
    'is_active',
    'declaration',
    'created_by',
    ];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = [
    'password',
    'remember_token',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
    protected $casts = [
    'email_verified_at' => 'datetime',
    ];

    protected function facility()
    {
      return $this->belongsTo(Facility::class,'facility_id','id');
    }

    protected function fullName(): Attribute
    {
      return Attribute::make(
      get: fn () => $this->title.' '.$this->surname.' '.$this->first_name.' '.$this->other_name,
      );
    }


    protected function passwordUpdatedAt(): Attribute
    {
      return new Attribute(
      get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i'),
      );
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
      ->where('surname', 'like', '%'.$search.'%')
      ->orWhere('first_name', 'like', '%'.$search.'%')
      ->orWhere('other_name', 'like', '%'.$search.'%')
      ->orWhere('name', 'like', '%'.$search.'%')
      ->orWhere('contact', 'like', '%'.$search.'%')
      ->orWhere('email', 'like', '%'.$search.'%');
    }
  }
