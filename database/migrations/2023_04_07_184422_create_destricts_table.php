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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code')->nullable();
            $table->string('is_urban')->nullable();
            $table->string('is_municipality')->nullable();
            $table->integer('ip')->nullable();
            $table->string('email', 50)->nullable();
            $table->boolean('districtAccountDetailsSent')->default(false);
            $table->foreignId('region_id')->nullable()->constrained('regions', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        DB::statement("
        INSERT INTO `districts` ( `region_id`, `is_urban`, `is_municipality`, `code`, `name`) VALUES
        (4, 'Yes', 'Yes', '09', 'Kampala District.');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destricts');
    }
};
