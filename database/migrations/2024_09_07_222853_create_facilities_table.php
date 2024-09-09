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
       
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('level', 50)->nullable();
            $table->foreignId('ip')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('dhis2_facility_name', 100)->nullable();
            $table->string('dhis2_facility_code', 50)->nullable();
            $table->string('ownership', 150)->nullable();
            $table->string('clinician_contact', 10)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('is_hub')->default(0);
            $table->boolean('is_training_partner')->default(false);
            $table->boolean('details_sent')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('district_id')->references('id')->on('districts')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreignId('sub_district_id')->references('id')->on('counties')->onDelete('RESTRICT')->onUpdate('CASCADE');
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
        Schema::dropIfExists('facilities');
    }
};
