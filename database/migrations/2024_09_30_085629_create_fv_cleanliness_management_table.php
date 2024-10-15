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
        Schema::create('fv_cleanliness_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->tinyInteger('lab_store_clean')->default(0)->nullable();  // 1 = Yes, 0 = No
            $table->boolean('main_store_clean')->default(0)->nullable();
            $table->boolean('laboratory_clean')->default(0)->nullable();
            $table->text('cleanliness_comments')->nullable();
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
        Schema::dropIfExists('fv_cleanliness_management');
    }
};
