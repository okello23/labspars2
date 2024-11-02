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
        Schema::create('fv_equipment_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('inventory_log_available'); // Yes/No for Inventory Log availability
            $table->boolean('inventory_log_updated'); // Yes/No for Inventory Log updated in the last year
            $table->boolean('service_info_available'); // Service information availability
            $table->boolean('equipment_serviced'); // Equipment serviced according to schedule
            $table->boolean('iqc_performed'); // Internal Quality Control performed
            $table->boolean('operator_manuals_available'); // Operator manuals available
            $table->float('equipment_inv_score')->nullable();
            $table->float('equipment_inv_percentage')->nullable(); 
            $table->float('equipment_score')->nullable();
            $table->float('equipment_percentage')->nullable(); 
            $table->string('equipment_mgt_comments')->nullable(); 
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
        Schema::dropIfExists('fv_equipment_management');
    }
};
