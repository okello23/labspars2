<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvEquipmentManagement extends Model
{
    use HasFactory;
    protected $fillable =[
        'visit_id',
        'inventory_log_available',
        'inventory_log_updated',
        'service_info_available',
        'equipment_serviced',
        'iqc_performed',
        'operator_manuals_available',
        'equipment_inv_score',
        'equipment_inv_percentage',
        'equipment_score',
        'equipment_percentage',
        'equipment_mgt_comments',
        'equipment_maintenance_comment',
    ];
}
