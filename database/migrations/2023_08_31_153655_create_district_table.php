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
        Schema::create('district', function (Blueprint $table) {
            $table->integer('districtId', true);
            $table->integer('region')->nullable();
            $table->integer('ip')->nullable();
            $table->string('districtName', 15);
            $table->string('districtEmail', 50)->nullable();
            $table->boolean('districtAccountDetailsSent')->default(false);
            $table->timestamp('districtAddTime')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district');
    }
};
