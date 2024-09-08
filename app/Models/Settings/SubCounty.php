<?php

namespace App\Models\Settings;

use App\Models\Settings\County;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCounty extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'dhis2_code',
        'code',
        'dhis2_district_code',
      ];
      public static function search($search)
      {
          return empty($search) ? static::query()
          : static::query()
              ->where('name', 'like', '%'.$search.'%');
      }
      
  
      public function county()
      {
          return $this->belongsTo(County::class, 'county_id', 'id');
      }
}
