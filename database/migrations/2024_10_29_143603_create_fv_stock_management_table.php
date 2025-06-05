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

    //  Does the facility carry out these tests (Assessor ask for all ten tracer items and score yes=1 and No=0	
    //  Is the Item available? (Score 1/0) - If expired, mark (E)	
    //  Is the Stock card available? (1/0)	
    //  Is a physical count (PC) done every month and marked in the stock card (check last 3 complete months) (1/0)	
    //  Is the card filled correctly with name, unit size, Min& Max, special storage (1/0)	
    //  Balance according to stock card (record no. from the card)	
    //  Count the no. of reagents in stock and record i.e. physical count (PC)	
    //  Does the balance according to the stock card agree with the PC 100%? (1/0)	
    //  Record the amount issued in the last 3 complete months.	
    //  Record the number of days out of stock in the last 3 complete months.	
    //  Record the average monthly consumption (AMC) as per the stock card. Write NR if not recorded. 	
    //  Calculate & record the AMC based on the last 3 complete months 	
    //  Does the AMC from the stock card agree with the calculated AMC ±10%? (1/0) Write NR if no record in C11 above	
    //  Does the facility have an ELMIS/EMR installed at the store? (1/0)	
    //  Record the quantity as per the ELMIS/EMR. Write NR if not recorded. 	
    //  Does the balance according to the ELMIS/EMR agree with the PC 100%? (1/0)
    public function up()
    {
        Schema::create('fv_stock_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('reagent_id')->constrained('reagents')->onDelete('cascade'); 
            $table->boolean('test_performed')->default(0); 
            $table->boolean('item_available')->default(0); 
            $table->boolean('stock_card_available')->default(0); 
            $table->boolean('physical_count_done')->default(0); 
            $table->boolean('stock_card_correct')->default(0); 
            $table->integer('balance_on_card')->nullable(); 
            $table->integer('physical_count')->nullable(); 
            $table->boolean('balance_matches_physical')->default(0); 
            $table->integer('last_issues')->nullable(); 
            $table->integer('out_of_stock_days')->nullable(); 
            $table->integer('amc_on_card')->nullable(); 
            $table->boolean('amc_calculated')->default(0); 
            $table->boolean('amc_calculated_matches')->default(0); 
            $table->boolean('elmis_installed')->default(0); 
            $table->integer('elmis_quantity')->default(0); 
            $table->boolean('elmis_balance_matches')->default(0); 
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('fv_stock_management');
    }
};
