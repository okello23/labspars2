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
        Schema::create('fv_adherences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->references('id')->on('facility_visits')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->date('ordering_schedule_deadline')->nullable();  // Ordering schedule deadline
            $table->date('actual_ordering_date')->nullable();  // Actual date of ordering
            $table->boolean('ordering_timely')->nullable();  // Was ordering timely (Yes/No)
            $table->date('delivery_schedule_deadline')->nullable();  // Delivery schedule deadline
            $table->date('delivery_date')->nullable(); // Actual date of delivery
            $table->boolean('delivery_on_time')->nullable(); // Was delivery on schedule (Yes/No)
            $table->text('adherence_comments')->nullable(); // Was delivery on schedule (Yes/No)
            $table->float('adherence_score')->nullable(); // Was delivery on schedule (Yes/No)
            $table->float('adherence_percentage')->nullable(); // Was delivery on schedule (Yes/No)
            $table->boolean('annual_procurement_plan')->default(0)->nullable();
            $table->text('procurement_plan_comments')->nullable();
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
        Schema::dropIfExists('fv_adherences');
    }
};
