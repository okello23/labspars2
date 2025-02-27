<?php

use App\Models\Settings\FilledReport;
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
        Schema::create('filled_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        $records = [
            'HMIS 105 (Section 10) monthly reports (Last 2 months)',
            'HMIS Lab 024 Bimonthly Report & Order Calculation Form for HIV Test Kits (Last 2 order cycles)', 
            'HMIS 025 Laboratory Order Form (Last 2 order cycles)',
            'HMIS PHAR 020 Requisition & Issue vouchers (Last 2 weeks)'            
        ];

        foreach ($records as $record) {
            FilledReport::create(['name' => $record]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filled_reports');
    }
};
