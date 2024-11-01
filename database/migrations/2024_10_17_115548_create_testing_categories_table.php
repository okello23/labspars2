<?php

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
        Schema::create('testing_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        $categories = [
            'HIV', 
            'TB', 
            'Malaria', 
            'Advanced HIV', 
            'CaCx', 
            'Haematology', 
            'Chemistry', 
            'Others'
        ];

        foreach ($categories as $category) {
            TestingCategory::create(['name' => $category]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testing_categories');
    }
};
