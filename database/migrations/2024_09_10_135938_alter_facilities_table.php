<?php
use Illuminate\Support\Facades\DB;
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
    Schema::table('facilities', function (Blueprint $table) {
      $table->dropColumn('ip');
      $table->dropColumn('parent_id');
      $table->dropColumn('dhis2_facility_name');
      $table->dropColumn('dhis2_facility_code');
      $table->dropColumn('clinician_contact');
      $table->dropColumn('email');
      $table->dropColumn('is_hub');
      $table->dropColumn('is_training_partner');
      $table->dropColumn('details_sent');
      $table->dropForeign(['district_id']);
      $table->dropColumn('district_id');

      $table->foreignId('sub_district_id')->after('is_active')->references('id')->on('health_sub_districts')->onDelete('RESTRICT')->onUpdate('CASCADE');
    });


        // DB::statement("");
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('facilities', function (Blueprint $table) {
      //
    });
  }
};
