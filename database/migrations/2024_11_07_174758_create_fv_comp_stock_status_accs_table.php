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
//     Is the previous HMIS 105 report and the stock card/book for the following commodities available?
// (1/0/NA)	Quantity consumed
// 	No. Of days out of stock	Stock on hand	Quantity consumed	No. Of days out of stock	Stock on hand	Do the report
// and stock card/ book
// data agree?
// (1/0/NA)


    public function up()
    {
        Schema::create('fv_comp_stock_status_accs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('stock_item_id')->references('id')->on('stock_items')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->integer('c_reports_available')->nullable();    

            $table->integer('chmis_qty_consumed')->nullable();
            $table->integer('chmis_days_out_of_stock')->nullable();
            $table->integer('chmis_Stock_on_hand')->nullable();

            $table->integer('csc_qty_consumed')->nullable();
            $table->integer('csc_days_out_of_stock')->nullable();
            $table->integer('csc_Stock_on_hand')->nullable();

            $table->integer('c_report_sc_agree')->nullable();

           
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
        Schema::dropIfExists('fv_comp_stock_status_accs');
    }
};
