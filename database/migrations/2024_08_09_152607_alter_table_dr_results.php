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
        Schema::table('dr_results', function (Blueprint $table) {
          $table->integer('accession_id')->after('id')->nullable();
          $table->foreign('accession_id')->references('id')->on('accessioned_samples')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dr_results', function (Blueprint $table) {
            //
        });
    }
};
