<?php

use App\Models\Settings\StockItem;
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
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->text('type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        $records = [
            'Determine HIV Screening test',
            'Stat -pack HIV Confirmatory rapid tests',
            'SD-Bioline HIV RDT Tie-breaker test',
            'CD4 reagent',
            'Malaria Rapid Diagnostic Test (RDT), 25 Tests',
            'GeneXpert Xpert MTB/RIF Ultra Assay, 50 Cartridges with Sample Reagent, 1 Kit',
            'HIV/Syphilis Duo Kit',
        ];

        foreach ($records as $record) {
            StockItem::create(['name' => $record]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_items');
    }
};
