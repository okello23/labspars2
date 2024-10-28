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
        Schema::create('fv_equipment_functionalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('equipment_id')->nullable()->references('id')->on('lab_platforms')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('equipment_name')->nullable(); // Type of equipment (e.g., CD4, Hematology)
            $table->string('equipment_type'); // Type of equipment (e.g., CD4, Hematology)
            $table->boolean('functional'); // Is the equipment functional
            $table->integer('downtime')->nullable(); // Downtime in months
            $table->boolean('nonfunctional_hw')->default(false); // Non-functional due to hardware/software
            $table->boolean('nonfunctional_reagents')->default(false); // Non-functional due to reagents
            $table->boolean('other_factors')->default(false); // Other non-functional factors
            $table->integer('response_time'); // Type of equipment (e.g., CD4, Hematology)
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
        Schema::dropIfExists('fv_equipment_functionalities');
    }
};
