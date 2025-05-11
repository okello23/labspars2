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
        Schema::create('fv_storage_practice_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('main_store_expired_record')->default(0)->nullable();
            $table->boolean('lab_store_expired_record')->default(0)->nullable();
            $table->boolean('main_store_expired_separate')->default(0)->nullable();
            $table->boolean('lab_store_expired_separate')->default(0)->nullable();
            $table->boolean('main_store_fefo')->default(0)->nullable();
            $table->boolean('lab_store_fefo')->default(0)->nullable();
            $table->boolean('main_store_opening_date')->default(0)->nullable();
            $table->boolean('lab_store_opening_date')->default(0)->nullable();
            $table->text('practices_comments')->nullable();

            $table->boolean('opened_bottles_have_lids')->nullable();
            $table->boolean('chemicals_properly_labelled')->nullable();
            $table->boolean('flammables_stored_safely')->nullable();
            $table->boolean('corrosives_separated')->nullable();
            $table->boolean('safety_data_sheets_available')->nullable();
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
        Schema::dropIfExists('fv_storage_practice_management');
    }
};
