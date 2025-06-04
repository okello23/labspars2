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
        Schema::table('fv_lis_hmis_reports', function (Blueprint $table) {
            $table->date('last_report_filling_date')->nullable();
        });
        Schema::table('fv_storage_condition_management', function (Blueprint $table) {
            $table->boolean('main_temperature_regulated')->nullable();
            $table->boolean('lab_temperature_regulated')->nullable();
            $table->boolean('main_roof_condition')->nullable();
            $table->boolean('lab_roof_condition')->nullable();
            $table->boolean('main_sufficient_storage_space')->nullable();
            $table->boolean('lab_sufficient_storage_space')->nullable();
            $table->boolean('main_fire_safety_equipment_available')->nullable();
            $table->boolean('lab_fire_safety_equipment_available')->nullable();
            $table->boolean('main_cold_storage_functional')->nullable();
            $table->boolean('lab_cold_storage_functional')->nullable();
            $table->boolean('main_fridge_well_ventilated')->nullable();
            $table->boolean('lab_fridge_well_ventilated')->nullable();
            $table->boolean('main_fridge_used_for_reagents_only')->nullable();
            $table->boolean('lab_fridge_used_for_reagents_only')->nullable();
            $table->boolean('main_containers_securely_capped')->nullable();
            $table->boolean('lab_containers_securely_capped')->nullable();
            $table->boolean('main_fridge_temperature_monitored')->nullable();
            $table->boolean('lab_fridge_temperature_monitored')->nullable();
            $table->boolean('main_boxes_not_on_floor')->nullable();
            $table->boolean('lab_boxes_not_on_floor')->nullable();
        });

        Schema::table('fv_storage_practice_management', function (Blueprint $table) {

            $table->boolean('main_opened_bottles_have_lids')->nullable();
            $table->boolean('lab_opened_bottles_have_lids')->nullable();
            $table->boolean('main_chemicals_properly_labelled')->nullable();
            $table->boolean('lab_chemicals_properly_labelled')->nullable();
            $table->boolean('main_flammables_stored_safely')->nullable();
            $table->boolean('lab_flammables_stored_safely')->nullable();
            $table->boolean('main_corrosives_separated')->nullable();
            $table->boolean('lab_corrosives_separated')->nullable();
            $table->boolean('main_safety_data_sheets_available')->nullable();
            $table->boolean('lab_safety_data_sheets_available')->nullable();
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
