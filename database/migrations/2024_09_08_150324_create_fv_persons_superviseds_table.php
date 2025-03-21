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
        Schema::create('fv_persons_superviseds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 50)->nullable();
            $table->string('contact', 20);
            $table->string('sex', 10);
            $table->string('profession', 150)->nullable();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
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
        Schema::dropIfExists('fv_persons_superviseds');
    }
};
