<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\LisDataCollectionTool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FvLisDataToolScore extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_id',
        'tool_id',
        'dct_availability_score',
        'dct_usage_score',
    ];
    public function dcTool()
    {
        return $this->belongsTo(LisDataCollectionTool::class, 'tool_id', 'id');
    }
}
