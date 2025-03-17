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
        Schema::table('facility_visits', function (Blueprint $table) {
            $table->dropUnique('facility_visits_in_charge_contact_unique');
            $table->dropUnique('facility_visits_in_charge_name_unique');          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_visits', function (Blueprint $table) {
            $table->unique('in_charge_contact', 'facility_visits_in_charge_contact_unique');
            $table->unique('in_charge_contact', 'facility_visits_in_name_contact_unique');
        });
    }
};
