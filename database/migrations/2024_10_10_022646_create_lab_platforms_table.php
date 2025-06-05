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
        Schema::create('lab_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Chemistry', 'Hematology', 'CD4']);
            $table->string('manufacturer')->nullable();
            $table->string('model_number')->nullable();
            $table->text('test_types_supported')->nullable();
            $table->string('methodology')->nullable();
            $table->string('sample_type')->nullable();
            $table->decimal('sample_volume_required', 5, 2)->nullable();
            $table->integer('throughput')->nullable();
            $table->string('accuracy')->nullable();
            $table->string('maintenance_frequency')->nullable();
            $table->string('calibration_frequency')->nullable();
            $table->string('storage_temperature')->nullable();
            $table->string('power_requirements')->nullable();
            $table->string('warranty_period')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('lab_platforms');
    }
};
