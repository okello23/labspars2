<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\TestingCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reagent extends Model
{
    use HasFactory;
    protected $fillable = ['testing_category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(TestingCategory::class,'testing_category_id','id');
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%');
    }
}
