<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PocEquipmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_date',
        'test_time',
        'error_code',
        'tested_by',
        'equipment_used',
        'equipment_serial_number',
        'catridge_serial_number',
        'machine_sample_detection',
        'device_status',
        'hiv1_positive_control',
        'hiv2_positive_control',
        'negative_control',
        'device_analysis',
        'device_software_version',
        'device_mode',
        'test_summary',
    ];
}
