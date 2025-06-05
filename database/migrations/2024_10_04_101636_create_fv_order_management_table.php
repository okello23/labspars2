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
        Schema::create('fv_order_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('cycles_filed_stored')->default(0)->nullable();
            $table->text('cycles_filed_comments')->nullable();
            $table->boolean('electronic_submission')->default(0)->nullable();
            $table->text('electronic_submission_comments')->nullable();
            $table->string('soh')->nullable(); // Stock on Hand (SOH)
            $table->integer('quantity_issued')->nullable();  // Quantity issued out (2 months)
            $table->integer('days_out_of_stock')->nullable();  // Days out of stock
            $table->integer('adjusted_amc')->nullable();  // Adjusted AMC
            $table->integer('max_quantity')->nullable();  // Maximum quantity (Adjusted AMC x 4)
            $table->integer('quantity_to_order')->nullable();  // Quantity to order (Max - SOH)
            $table->boolean('qty_to_order_score')->nullable();  // Quantity to order (Max - SOH)
            $table->boolean('test_menu_available')->default(0)->nullable();


            $table->float('response_score')->nullable();
            $table->float('response_percentage')->nullable();
            $table->float('plan_score')->nullable();
            $table->float('plan_percentage')->nullable();

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
        Schema::dropIfExists('fv_order_management');
    }
};
