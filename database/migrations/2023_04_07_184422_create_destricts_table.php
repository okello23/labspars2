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
        INSERT INTO districts (name,region_id) VALUES
        	 ('Buikwe',1),
        	 ('Bukomansimbi',1),
        	 ('Gomba',1),
        	 ('Kalungu',1),
        	 ('Kayunga',1),
        	 ('Luwero',1),
        	 ('Lyantonde',1),
        	 ('Masaka',1),
        	 ('Mityana',1),
        	 ('Mpigi',1),
        	 ('Mukono',1),
        	 ('Nakasongola',1),
        	 ('Sembabule',1),
        	 ('Butambala',1),
        	 ('Lwengo',1),
        	 ('Rakai',1),
        	 ('Buliisa',2),
        	 ('Bundibugyo',2),
        	 ('Hoima',2),
        	 ('Ibanda',2),
        	 ('Isingiro',2),
        	 ('Kabale',2),
        	 ('Rubanda',2),
        	 ('Kabarole',2),
        	 ('Kamwenge',2),
        	 ('Kasese',2),
        	 ('Kakumiro',2),
        	 ('Kagadi',2),
        	 ('Kibaale',2),
        	 ('Kiruhura',2),
        	 ('Kisoro',2),
        	 ('Kyenjojo',2),
        	 ('Mbarara',2),
        	 ('Rukungiri',2),
        	 ('Apac',3),
        	 ('Oyam',3),
        	 ('Moyo',3),
        	 ('Maracha',3),
        	 ('Abim',3),
        	 ('Nebbi',3),
        	 ('Pader',3),
        	 ('Amolatar',3),
        	 ('Koboko',3),
        	 ('Jinja',4),
        	 ('Amuria',4),
        	 ('Bugiri',4),
        	 ('Bukedea',4),
        	 ('Bukwo',4),
        	 ('Butaleja',4),
        	 ('Kaberamaido',4),
        	 ('Kapchorwa',4),
        	 ('Katakwi',4),
        	 ('Kumi',4),
        	 ('Manafwa',4),
        	 ('Mayuge',4),
        	 ('Mbale',4),
        	 ('Namutumba',4),
        	 ('Ngora',4),
        	 ('Pallisa',4),
        	 ('Soroti',4),
        	 ('Tororo',4),
        	 ('Serere',4),
        	 ('Buvuma',1),
        	 ('Kalangala',1),
        	 ('Kampala',1),
        	 ('Kiboga',1),
        	 ('Kyankwanzi',1),
        	 ('Mubende',1),
        	 ('Nakaseke',1),
        	 ('Wakiso',1),
        	 ('Budaka',4),
        	 ('Bududa',4),
        	 ('Bulambuli',4),
        	 ('Busia',4),
        	 ('Buyende',4),
        	 ('Iganga',4),
        	 ('Kaliro',4),
        	 ('Kamuli',4),
        	 ('Kibuku',4),
        	 ('Kween',4),
        	 ('Luuka',4),
        	 ('Namayingo',4),
        	 ('Sironko',4),
        	 ('Adjumani',3),
        	 ('Agago',3),
        	 ('Alebtong',3),
        	 ('Amudat',3),
        	 ('Amuru',3),
        	 ('Arua',3),
        	 ('Dokolo',3),
        	 ('Gulu',3),
        	 ('Omoro',3),
        	 ('Kaabong',3),
        	 ('Kitgum',3),
        	 ('Kole',3),
        	 ('Kotido',3),
        	 ('Lamwo',3),
        	 ('Lira',3),
        	 ('Moroto',3),
        	 ('Nakapiripiri',3),
        	 ('Napak',3),
        	 ('Nwoya',3),
        	 ('Otuke',3),
        	 ('Yumbe',3),
        	 ('Zombo',3),
        	 ('Buhweju',2),
        	 ('Bushenyi',2),
        	 ('Kanungu',2),
        	 ('Kiryandongo',2),
        	 ('Kyegegwa',2),
        	 ('Masindi',2),
        	 ('Mitooma',2),
        	 ('Ntoroko',2),
        	 ('Ntungamo',2),
        	 ('Rubirizi',2),
        	 ('Sheema',2)");
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
