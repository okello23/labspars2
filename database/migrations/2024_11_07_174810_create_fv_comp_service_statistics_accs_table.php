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
        Schema::create('fv_comp_service_statistics_accs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('service_name');                       
            $table->integer('service_statistics_available')->nullable();
            $table->integer('hims_tests_reported')->nullable();
            $table->integer('lab_reg_tests_reported')->nullable();
            $table->integer('hims_lab_tests_balance')->nullable();
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
        Schema::dropIfExists('fv_comp_service_statistics_accs');
    }
};
