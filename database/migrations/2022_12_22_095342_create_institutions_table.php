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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('name')->unique();
            $table->string('short_code')->nullable();
            $table->string('identifier', 30)->unique();
            $table->string('contact', 20)->nullable();
            $table->string('alt_contact', 20)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('address')->nullable();
            $table->integer('is_active')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('institutions');
    }
};
