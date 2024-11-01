<?php

use App\Models\Settings\Reagent;
use Illuminate\Support\Facades\Schema;
use App\Models\Settings\TestingCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reagents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('testing_category_id')->nullable()->references('id')->on('testing_categories')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        $reagents = [
            ['category' => 'HIV', 'reagent' => 'Determine strips, 100 Tests'],
            ['category' => 'HIV', 'reagent' => 'DBS Collection Set, 50 Tests'],
            ['category' => 'TB', 'reagent' => 'GeneXpert Xpert MTB/RIF Ultra Assay, 50 Cartridges with Sample Reagent, 1 Kit'],
            ['category' => 'HIV', 'reagent' => 'Plasma Collection Tube, K2-EDTA + PPT Polymer Gel, 5ml, Plastic, White Top, Sterile'],
            ['category' => 'Malaria', 'reagent' => 'Malaria Rapid Diagnostic Test (RDT), 25 Tests'],
            ['category' => 'Advanced HIV', 'reagent' => 'Visitect CD4 Advanced Disease, 25 Tests'],
            ['category' => 'HIV', 'reagent' => 'HIV/Syphilis Duo Kit / HIV-1/2 (Standard Q HIV/Syphilis Combo Test Bundle, 25 Tests'],
            ['category' => 'CaCx', 'reagent' => 'GeneXpert Xpert HPV Assay, 10 Cartridges, 1 Kit'],
            ['category' => 'Advanced HIV', 'reagent' => 'Pima CD4 Cartridges (100 Tests)'],
            ['category' => 'Haematology', 'reagent' => 'Blood Grouping Reagent, 10 mL Vial (Anti A,B, AB, D)'],
            ['category' => 'Chemistry', 'reagent' => 'Blood Glucose Test Strips, 50 Tests'],
            ['category' => 'TB', 'reagent' => 'Strong Carbol Fuchsin 1000ml Solution'],
            ['category' => 'Others', 'reagent' => 'Hepatitis B Rapid Diagnostic Test (RDT) HBsAg, 100 Tests'],
            ['category' => 'HIV', 'reagent' => 'GeneXpert Xpert HIV-1/VL Assay, 10 Cartridges with Sample Reagent, 1 Unit'],
            ['category' => 'HIV', 'reagent' => 'm-Pima HIV-1/2 Detect, 50 Tests']
        ];

        foreach ($reagents as $data) {
            $category = TestingCategory::where('name', $data['category'])->first();
            if ($category) {
            }else{
               $category = TestingCategory::create(['name' => $category]);
            }            
            Reagent::create([
                'testing_category_id' => $category->id,
                'name' => $data['reagent']
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reagents');
    }
};
