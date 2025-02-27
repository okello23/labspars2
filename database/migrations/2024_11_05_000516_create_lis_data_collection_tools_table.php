<?php

use App\Models\Settings\LisDataCollectionTool;
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
        Schema::create('lis_data_collection_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        $categories = [
            'HMIS Lab 001 General Laboratory Request Form',
            'HMIS Lab 002 Laboratory Specimen Reception Register',
            'HMIS Lab 004 General Laboratory Test Result Form',
            'HMIS Lab 005 Laboratory Specimen Referral Register',
            'HMIS Lab 010 HC II & HC III Daily Activity Register for General Analysis',
            'HMIS Lab 011 HC IV & Gen Hosp Daily Activity Register for General Analysis',
            'HMIS Lab 012 Hosp Gen Clinical Chem Register for Daily Activity & General Analysis',
            'HMIS Lab 014 Daily Activity Haematology Register',  
            'HMIS Lab 015 Daily Activity Register for Viral Load, CD4, TB LAM & CrAg', 
            'HMIS Lab 016 Daily Activity Register for HIV Tests',
            'HMIS Lab 019 Facility Biosafety & Biosecurity Incident Register',
            'HMIS Lab 020 Laboratory Equipment Inventory Log', 
            'HMIS Lab 022 Laboratory Equipment Breakdown Register', 
            'HMIS Lab 023 Laboratory Equipment Maintenance Log', 
            'HMIS PHAR 021 Bimonthly Report & Order Calculation Form for HIV Test Kits',  
            'HMIS PHAR 023 Laboratory Order Form'            
        ];

        foreach ($categories as $category) {
            LisDataCollectionTool::create(['name' => $category]);
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lis_data_collection_tools');
    }
};
