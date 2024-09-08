<?php

namespace App\Models\Settings;

use App\Models\Settings\SubCounty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parish extends Model
{
    use HasFactory;
    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%');
    }
    

    public function subcounty()
    {
        return $this->belongsTo(SubCounty::class, 'sub_county_id', 'id');
    }

}
