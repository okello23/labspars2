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
        Schema::create('fv_hygiene_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('running_water')->default(0)->nullable();
            $table->boolean('hand_washing_separate')->default(0)->nullable();
            $table->boolean('hand_washing_facility')->default(0)->nullable();
            $table->boolean('drainage_system')->default(0)->nullable();
            $table->boolean('soap_available')->default(0)->nullable();
            $table->text('hygiene_comments')->nullable();
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
        Schema::dropIfExists('fv_hygiene_management');
    }
};
