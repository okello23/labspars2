<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::dropIfExists('fv_storage_types');
        Schema::create('fv_storage_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
        DB::statement("
        INSERT INTO `fv_storage_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`, `description`, `updated_by`, `created_by`) VALUES
        (1, 'Main store', 1, '2024-09-08 18:49:42', '2024-09-08 18:49:42', 'jwqnsq  snqs q', NULL, NULL),
        (2, 'Laboratory store', 1, '2024-09-08 18:57:52', '2024-09-08 18:57:52', 'Laboratory store', NULL, null),
        (3, 'Pharmacy store', 1, '2024-09-08 18:58:08', '2024-09-08 18:58:08', 'Pharmacy store', NULL, null),
        (4, 'Wards', 1, '2024-09-08 19:00:39', '2024-09-08 19:00:39', 'Wards', NULL, 1),
        (5, 'Cabinets in the laboratory', 1, '2024-09-08 19:01:05', '2024-09-08 19:01:05', 'Cabinets in the laboratory', NULL, null),
        (6, 'Other stores', 1, '2024-09-08 19:17:11', '2024-09-08 19:17:11', 'Other stores, please specify ', NULL, null);
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fv_storage_types');
    }
};
