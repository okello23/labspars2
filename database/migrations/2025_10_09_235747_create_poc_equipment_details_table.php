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
        Schema::create('poc_equipment_details', function (Blueprint $table) {
            $table->id();
            $table->date('test_date');
            $table->time('test_time');
            $table->string('error_code')->nullable();
            $table->string('tested_by');
            $table->string('equipment_used');
            $table->string('equipment_serial_number');
            $table->string('catridge_serial_number');
            $table->boolean('machine_sample_detection')->nullable();
            $table->string('device_status')->nullable();
            $table->string('hiv1_positive_control');
            $table->string('hiv2_positive_control');
            $table->string('negative_control');
            $table->text('device_analysis')->nullable();
            $table->string('device_software_version')->nullable();
            $table->string('device_mode')->nullable();
            $table->text('test_summary')->nullable();
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
        Schema::dropIfExists('poc_equipment_details');
    }
};
