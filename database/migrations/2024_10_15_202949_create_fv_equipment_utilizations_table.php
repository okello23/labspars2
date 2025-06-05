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
        Schema::create('fv_equipment_utilizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('equipment_id')->nullable()->references('id')->on('lab_platforms')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('equipment_name')->nullable(); 
            $table->string('equipment_type'); 
            $table->integer('through_put'); 
            $table->integer('running_days'); 
            $table->integer('actual_output'); 
            $table->integer('expected_output'); 
            $table->integer('utilization'); 
            $table->integer('greater_score'); 
            $table->integer('capacity'); 
            $table->integer('final_score'); 
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
        Schema::dropIfExists('fv_equipment_utilizations');
    }
};
