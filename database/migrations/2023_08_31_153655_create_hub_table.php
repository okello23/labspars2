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
        Schema::create('hub', function (Blueprint $table) {
            $table->integer('hubId', true);
            $table->integer('region')->nullable();
            $table->integer('ip')->nullable();
            $table->string('hubName', 50);
            $table->string('hubEmail', 60)->nullable();
            $table->boolean('hubAccountDetailsSent')->default(false);
            $table->timestamp('hubAddTime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hub');
    }
};
