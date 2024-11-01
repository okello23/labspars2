<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','is_active'];

    public function reagents()
    {
        return $this->hasMany(Reagent::class);
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('name', 'like', '%'.$search.'%');
    }
}
