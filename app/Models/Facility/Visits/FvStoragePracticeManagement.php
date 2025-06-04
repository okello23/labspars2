<?php
namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvStoragePracticeManagement extends Model
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
        'main_opened_bottles_have_lids',
        'lab_opened_bottles_have_lids',
        'main_chemicals_properly_labelled',
        'lab_chemicals_properly_labelled',
        'main_flammables_stored_safely',
        'lab_flammables_stored_safely',
        'main_corrosives_separated',
        'lab_corrosives_separated',
        'main_safety_data_sheets_available',
        'lab_safety_data_sheets_available',

    ];
}
