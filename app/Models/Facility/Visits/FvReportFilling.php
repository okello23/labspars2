<?php

namespace App\Models\Facility\Visits;

use App\Models\Settings\FilledReport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvReportFilling extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_id',
        'report_id',
        'filling_score',
        'comments',
    ];

    public function report()
    {
        return $this->belongsTo(FilledReport::class, 'report_id', 'id');
    }
}
