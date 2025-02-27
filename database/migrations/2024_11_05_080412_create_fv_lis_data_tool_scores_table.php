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
        Schema::create('fv_lis_data_tool_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('tool_id')->references('id')->on('lis_data_collection_tools')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->integer('dct_availability_score')->nullable();
            $table->integer('dct_usage_score')->nullable();
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
        Schema::dropIfExists('fv_lis_data_tool_scores');
    }
};
