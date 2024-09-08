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
        Schema::create('sub_counties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code')->nullable();
            $table->foreignId('county_id')->nullable()->constrained('counties', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        DB::statement("
            INSERT INTO `sub_counties` (`code`, `county_id`,`id`, `name`) VALUES
            (508, 1, '1', 'KAMPALA CENTRAL DIVISION.'),
            (509, 2, '2', 'KAWEMPE DIVISION.'),
            (510, 4, '3', 'MAKERERE UNIVERSITY.'),
            (511, 3, '4', 'MAKINDYE DIVISION.'),
            (512, 4, '5', 'RUBAGA DIVISION.'),
            (513, 5, '6', 'NAKAWA DIVISION.'),
            (518, 3, '7', 'New Makindye.');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_counties');
    }
};
