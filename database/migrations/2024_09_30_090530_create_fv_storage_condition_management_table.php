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
        Schema::create('fv_storage_condition_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('main_store_pests')->default(0)->nullable();
            $table->boolean('lab_store_pests')->default(0)->nullable();
            $table->boolean('main_store_sunlight')->default(0)->nullable();
            $table->boolean('lab_store_sunlight')->default(0)->nullable();
            $table->boolean('main_store_temperature')->default(0)->nullable();
            $table->boolean('lab_store_temperature')->default(0)->nullable();
            $table->boolean('main_store_lockable')->default(0)->nullable();
            $table->boolean('lab_store_lockable')->default(0)->nullable();
            $table->text('condition_comments')->nullable();
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
        Schema::dropIfExists('fv_storage_condition_management');
    }
};
