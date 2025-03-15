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
        Schema::table('fv_equipment_management', function (Blueprint $table) {
            $table->float('maintenance_score')->nullable();
            $table->float('maintenance_percentage')->nullable(); 
            $table->string('equipment_mgt_comments')->nullable()->change(); 
            $table->string('equipment_maintenance_comment')->nullable(); 
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
