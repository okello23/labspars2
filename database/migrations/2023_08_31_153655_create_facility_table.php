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
        Schema::create('facility', function (Blueprint $table) {
            $table->integer('facilityId', true);
            $table->string('facilityName', 100)->nullable();
            $table->string('level', 30)->nullable();
            $table->integer('ip')->nullable();
            $table->integer('district')->nullable();
            $table->integer('hub')->nullable();
            $table->string('dhis2FacilityName', 100)->nullable();
            $table->string('dhis2FacilityCode', 50)->nullable();
            $table->string('clinicianContact', 10)->nullable();
            $table->string('facilityEmail', 100)->nullable();
            $table->boolean('facilityAccountDetailsSent')->default(false);
            $table->timestamp('facilityAddTime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility');
    }
};
