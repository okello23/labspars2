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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('title', 6)->nullable();
            $table->string('surname', 25);
            $table->string('first_name', 25);
            $table->string('other_name', 25)->nullable();
            $table->string('name', 25);
            $table->string('contact', 20)->nullable();
            $table->string('email', 30)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('password_updated_at')->default(now());
            $table->string('avatar')->nullable();
            $table->boolean('declaration')->default(0);
            $table->string('signature')->nullable();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('two_factor_auth_enabled')->default(false);
            $table->string('two_factor_channel')->nullable();
            $table->string('two_factor_code')->nullable();
            $table->dateTime('two_factor_expires_at');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
