<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
       
            Schema::create('regions', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100)->unique();
                $table->string('code')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');            
                $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
                $table->timestamps();
            });
            DB::statement("
            INSERT INTO `regions` (`code`, `name`) VALUES
            (2, 'North'),
            (3, 'East'),
            (4, 'South'),
            (5, 'Central'),
            (6, 'Western');
            ");
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
};
