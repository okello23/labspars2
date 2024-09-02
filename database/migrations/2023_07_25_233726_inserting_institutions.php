<?php

use App\Models\NetworkManagement\Institution;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('institutions')->truncate();

        DB::statement("

                INSERT INTO `institutions` (`id`, `category`, `name`, `short_code`, `identifier`, `contact`, `email`, `address`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
                (1, 'Core Institution', 'JOINT CLINICAL RESEARCH CENTER (JCRC), Entebbe, Uganda', 'JCRC', 'NGRL-INST-001', '+256-705569999', 'jcrc@ngrl.org', 'Entebbe', 1, NULL, '2023-07-06 09:37:56', '2023-07-14 22:46:15')

        ");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
