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
            $table->enum('status', ['Pending','Submitted','Reviewed','Approved'])->after('created_by')->default('Pending');
            $table->string('stage')->after('created_by')->default('Lab Information');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_visits');
    }
};
