<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilledReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'description',
    ];
}
