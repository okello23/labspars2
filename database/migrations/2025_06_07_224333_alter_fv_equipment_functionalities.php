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
        Schema::table('fv_equipment_functionalities', function (Blueprint $table) {
                $table->integer('response_time')->nullable()->change();

       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fv_equipment_functionalities', function (Blueprint $table) {
            //
        });
    }
};
