<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('fv_lis_hmis_reports');
        Schema::create('fv_lis_hmis_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
                       
            $table->boolean('hmis_105_outpatient_report')->nullable();
            $table->boolean('hmis_105_previous_months')->nullable();
            $table->integer('lis_availability_score')->nullable();
            $table->integer('lis_availability_percentage')->nullable();
            $table->text('lis_availability_comments')->nullable();

            $table->boolean('t_reports_submitted_to_district')->nullable();
            $table->boolean('t_reports_submitted_on_time')->nullable();
            $table->integer('timeliness_score')->nullable();
            $table->integer('timeliness_percentage')->nullable();
            $table->text('timeliness_comments')->nullable();
            
            $table->boolean('hmis_section_6_complete')->nullable();
            $table->boolean('hmis_section_10_complete')->nullable();
            $table->integer('completeness_score')->nullable();
            $table->integer('completeness_percentage')->nullable();

            $table->text('lis_tools_comments')->nullable();

            $table->integer('total_availability_sum')->nullable();
            $table->integer('total_availability_percentage')->nullable();

            $table->integer('total_inuse_sum')->nullable();
            $table->integer('total_inuse_percentage')->nullable();

            $table->integer('availability_inuse_sum')->nullable();
            $table->integer('availability_inuse_percentage')->nullable();

            $table->text('hmis_105_report_comments')->nullable();
            $table->integer('hmis_105_report_score')->nullable();
            $table->integer('hmis_105_report_percentage')->nullable();

            $table->text('lab_data_usage_comments')->nullable();
            $table->integer('lab_data_usage_score')->nullable();
            $table->integer('lab_data_usage_percentage')->nullable();

            $table->text('reports_filling_comments')->nullable();
            $table->integer('reports_filling_score')->nullable();
            $table->integer('reports_filling_percentage')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fv_lis_hmis_reports');
    }
};
