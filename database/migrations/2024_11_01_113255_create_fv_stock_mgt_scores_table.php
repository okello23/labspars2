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
        Schema::dropIfExists('fv_stock_mgt_scores');
        Schema::create('fv_stock_mgt_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->float('availability_score')->nullable(); 
            $table->float('availability_percentage')->nullable(); 
            $table->float('stock_card_score')->nullable(); 
            $table->float('stock_card_percentage')->nullable(); 
            $table->float('correct_filling_score')->nullable(); 
            $table->float('correct_filling_percentage')->nullable(); 
            $table->float('physical_agrees_score')->nullable(); 
            $table->float('physical_agrees_percentage')->nullable(); 
            $table->float('amc_well_calculated_score')->nullable(); 
            $table->float('amc_well_calculated_percentage')->nullable(); 
            $table->float('emr_usage_score')->nullable(); 
            $table->float('emr_usage_percentage')->nullable(); 
            $table->text('stock_mgt_comments')->nullable(); 
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
        Schema::dropIfExists('fv_stock_mgt_scores');
    }
};
