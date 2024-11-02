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
        Schema::create('fv_lis_hmis_reports', function (Blueprint $table) {
            $table->id();
            Lab_copies_available
            Monthly_previous_reports
            availability_score
            availability_percentage

            $table->boolean('t_reports_submitted_to_district')->default(false);
            $table->boolean('t_reports_submitted_on_time')->default(false);
            $table->integer('timeliness_score')->nullable();
            $table->integer('timeliness_percentage')->nullable();

            
            $table->boolean('hmis_sect6_submitted')->default(false);
            $table->boolean('hmis_sect10_submittedt')->default(false);
            $table->integer('completeness_score')->nullable();
            $table->integer('completeness_percentage')->nullable();


            $table->integer('accuracy_score')->nullable();
            $table->integer('accuracy_percentage')->nullable();
            $table->text('lis_hmis_report_comments')->nullable();
            $table->text('lis_hmis_general_score')->nullable();
            $table->text('lis_hmis_percentage')->nullable();
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
