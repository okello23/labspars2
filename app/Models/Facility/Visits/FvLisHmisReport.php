<?php

namespace App\Models\Facility\Visits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvLisHmisReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'visit_id',
        'hmis_105_outpatient_report',
        'hmis_105_previous_months',
        'lis_availability_score',
        'lis_availability_percentage',
        'lis_availability_comments',
        't_reports_submitted_to_district',
        't_reports_submitted_on_time',
        'timeliness_score',
        'timeliness_percentage',
        'timeliness_comments',            
        'hmis_section_6_complete',
        'hmis_section_10_complete',
        'completeness_score',
        'completeness_percentage',
        'lis_tools_comments',
        'total_availability_sum',
        'total_availability_percentage',
        'total_inuse_sum',
        'total_inuse_percentage',
        'availability_inuse_sum',
        'availability_inuse_percentage',
        'hmis_105_report_comments',
        'hmis_105_report_score',
        'hmis_105_report_percentage',
        'lab_data_usage_comments',
        'lab_data_usage_score',
        'lab_data_usage_percentage',
        'reports_filling_comments',
        'reports_filling_score',
        'reports_filling_percentage',
    ];
}
