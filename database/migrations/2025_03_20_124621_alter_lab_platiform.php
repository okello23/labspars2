<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("ALTER TABLE `lab_platforms` CHANGE `type` `type` ENUM('Chemistry','Hematology','CD4','POC') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

};
