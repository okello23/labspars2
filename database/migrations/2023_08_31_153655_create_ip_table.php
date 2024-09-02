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
        Schema::create('ip', function (Blueprint $table) {
            $table->integer('ipId', true);
            $table->integer('asp')->nullable()->index('asp');
            $table->string('ipName', 50)->nullable();
            $table->string('ipContactName', 50)->nullable();
            $table->string('ipEmail', 50)->nullable();
            $table->string('ipContactTelecom', 10)->nullable();
            $table->boolean('ipAccountDetailsSent')->default(false);
            $table->dateTime('ipAddTime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip');
    }
};
