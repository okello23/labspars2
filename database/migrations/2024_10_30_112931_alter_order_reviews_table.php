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
        Schema::table('fv_order_reviews', function (Blueprint $table) {
            $table->foreignId('order_item_id')->nullable()->constrained('reagents')->onDelete('cascade')->after('item'); 
            $table->string('item')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('fv_order_reviews');
    }
};
