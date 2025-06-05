<?php
namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvStorageConditionManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'main_store_expired_record',
        'lab_store_expired_record',
        'main_store_expired_separate',
        'lab_store_expired_separate',
        'main_store_fefo',
        'lab_store_fefo',
        'main_store_opening_date',
        'lab_store_opening_date',
        'practices_comments',
        'condition_comments',
        'main_temperature_regulated',
        'lab_temperature_regulated',
        'main_roof_condition',
        'lab_roof_condition',
        'main_sufficient_storage_space',
        'lab_sufficient_storage_space',
        'main_fire_safety_equipment_available',
        'lab_fire_safety_equipment_available',
        'main_cold_storage_functional',
        'lab_cold_storage_functional',
        'main_fridge_well_ventilated',
        'lab_fridge_well_ventilated',
        'main_fridge_used_for_reagents_only',
        'lab_fridge_used_for_reagents_only',
        'main_containers_securely_capped',
        'lab_containers_securely_capped',
        'main_fridge_temperature_monitored',
        'lab_fridge_temperature_monitored',
        'main_boxes_not_on_floor',
        'lab_boxes_not_on_floor',
    ];
}
