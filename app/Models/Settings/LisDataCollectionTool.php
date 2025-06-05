<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LisDataCollectionTool extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
}
