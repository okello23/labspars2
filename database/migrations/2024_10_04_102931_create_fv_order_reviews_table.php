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
        Schema::create('fv_order_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->string('item');
            $table->integer('quantity_ordered'); // Quantity ordered
            $table->integer('quantity_received'); // Quantity received
            $table->float('fulfillment_rate'); // Order Fulfillment Rate (B/A*100)
            $table->float('review_score')->nullable(); // Was delivery on schedule (Yes/No)
            $table->float('review_percentage')->nullable(); // Was delivery on schedule (Yes/No)
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
        Schema::dropIfExists('fv_order_reviews');
    }
};
