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
        Schema::table('institutions', function (Blueprint $table) {
          $table->unsignedBigInteger('is_hub')->default(0);
          $table->unsignedBigInteger('district_id')->nullable();
          $table->unsignedBigInteger('hub_id')->nullable();
          $table->unsignedBigInteger('region_served')->nullable();
          $table->tinyInteger('is_training_partner')->nullable();
          // $table->integer('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutions', function (Blueprint $table) {
            //
        });
    }
};
