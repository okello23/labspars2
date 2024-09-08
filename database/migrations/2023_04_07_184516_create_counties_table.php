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
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code')->nullable();
            $table->foreignId('district_id')->nullable()->constrained('districts', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        DB::statement("
                INSERT INTO `counties` (`code`,`district_id`, `id`, `name`) VALUES
                (84, 1, 1, 'CENTRAL DIVISION.'),
                (85, 1, 2, 'KAWEMPE DIVISION.'),
                (87, 1, 3, 'MAKINDYE DIVISION.'),
                (89, 1, 4, 'RUBAGA DIVISION.'),
                (91, 1, 5, 'NAKAWA DIVISION.');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
};
