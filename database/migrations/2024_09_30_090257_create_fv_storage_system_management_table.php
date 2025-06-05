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
        Schema::create('fv_storage_system_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('main_store_shelves')->default(0)->nullable();
            $table->boolean('lab_store_shelves')->default(0)->nullable();
            $table->boolean('main_store_reagents')->default(0)->nullable();
            $table->boolean('lab_store_reagents')->default(0)->nullable();
            $table->boolean('main_store_stock_cards')->default(0)->nullable();
            $table->boolean('lab_store_stock_cards')->default(0)->nullable();
            $table->boolean('main_store_systematic')->default(0)->nullable();
            $table->boolean('lab_store_systematic')->default(0)->nullable();
            $table->boolean('main_store_labeled')->default(0)->nullable();
            $table->boolean('lab_store_labeled')->default(0)->nullable();
            $table->text('storage_comments')->nullable();
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
        Schema::dropIfExists('fv_storage_system_management');
    }
};
