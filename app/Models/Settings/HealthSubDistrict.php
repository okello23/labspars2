<?php

namespace App\Models\Settings;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthSubDistrict extends Model
{
    use HasFactory;

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhereHas('district', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
