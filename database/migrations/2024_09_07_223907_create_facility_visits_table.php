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
        
        Schema::create('facility_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visit_code',20)->unique();
            $table->string('visit_number',50);
            $table->string('in_charge_name',100)->unique();
            $table->string('in_charge_contact',20)->unique();
            $table->string('responsible_lss_name',150)->nullable();
            $table->foreignId('facility_id')->references('id')->on('districts')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->boolean('use_stock_cards')->default(true);
            $table->date('date_of_visit');
            $table->date('date_of_next_visit');
            $table->text('consumption_reconciliation')->nullable();
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
        Schema::dropIfExists('facility_visits');
    }
};
