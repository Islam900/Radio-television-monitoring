<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        $admin = User::create([
            'stations_id'       => NULL,
            'name_surname'      => 'Şıxıyev Cavid Çapar',
            'email'             => 'admin@gmail.com',
            'contact_number'    => null,
            'type'              => 'admin',
            'position'          => 'Administrator',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        // Mehdiabad
        User::create([
            'stations_id'       => 1,
            'name_surname'      => 'Heybətov Qoşqar Gülbala',
            'email'             => 'qoshqar.heybatov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 1,
            'name_surname'      => 'Bağırov Namiq Oktay',
            'email'             => 'namiq.bagirov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Böyük mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 1,
            'name_surname'      => 'Eynalov Mehman Telman',
            'email'             => 'mehman.eynalov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        // Yasamal
        User::create([
            'stations_id'       => 2,
            'name_surname'      => 'Mirzəyev Adəm Fazil',
            'email'             => 'adam.mirzayev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 2,
            'name_surname'      => 'İsmayılov Orxan Çingiz',
            'email'             => 'orxan.ismayilov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Böyük mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 2,
            'name_surname'      => 'Qaffarov Səbuhi Sabir',
            'email'             => 'sabuhi.qaffarov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        // Gunesli
        User::create([
            'stations_id'       => 3,
            'name_surname'      => 'Musayev Vüqar Qəzənfər oğlu',
            'email'             => 'vugar.musayev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 3,
            'name_surname'      => 'Əsədzadə Fazil Mahmud oğlu',
            'email'             => 'fazil.asadzada@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        // Gence
        User::create([
            'stations_id'       => 4,
            'name_surname'      => 'Qəhrəmanov Fəzail Kəmail',
            'email'             => 'fazail.gahramanov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 4,
            'name_surname'      => 'Məmmədov Ümüd İsrail',
            'email'             => 'umud.mammadov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 4,
            'name_surname'      => 'Məmmədov Qədim Məhəmməd',
            'email'             => 'qadim.mammadov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        // Qazax
        User::create([
            'stations_id'       => 5,
            'name_surname'      => 'Qurbanov Rauf Yusif',
            'email'             => 'rauf.gurbanov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 5,
            'name_surname'      => 'Həsənov Məzahir Şahvələd',
            'email'             => 'mazahir.hasanov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        //Qebele
        User::create([
            'stations_id'       => 6,
            'name_surname'      => 'Aslanov Feyruz',
            'email'             => 'feyruz.aslanov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 6,
            'name_surname'      => 'Mahmudov Rauf Rüstəm',
            'email'             => 'rauf.mahmudov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        //Zaqatala
        User::create([
            'stations_id'       => 7,
            'name_surname'      => 'Şirinov Elşən Nadir',
            'email'             => 'elshan.shirinov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 7,
            'name_surname'      => 'İbrahimov Azər Zeynal',
            'email'             => 'azar.ibrahimov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        // Quba regional məntəqəsi
        User::create([
            'stations_id'       => 8,
            'name_surname'      => 'Kiçibəyov Tofiq Şixsəfa',
            'email'             => 'tofiq.kichibayov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 8,
            'name_surname'      => 'Rəhimov Elnur Seyidəhməd',
            'email'             => 'elnur.rahimov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 8,
            'name_surname'      => 'Əliyev Vüsal Hikmət',
            'email'             => 'vusal.aliyev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);


        // Masallı regional məntəqəsi
        User::create([
            'stations_id'       => 9,
            'name_surname'      => 'Kərimov Hikmət Aydın',
            'email'             => 'hikmat.karimov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 9,
            'name_surname'      => 'Şənmədov Ağakərim Məhəmməd',
            'email'             => 'agakarim.shanmadov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 9,
            'name_surname'      => 'Ağayev Hidayət Canəli',
            'email'             => 'hidayat.agayev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);


        // Astara regional məntəqəsi
        User::create([
            'stations_id'       => 10,
            'name_surname'      => 'Quliyev Firudin Arif',
            'email'             => 'firudin.quliyev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 10,
            'name_surname'      => 'Xankişiyev Emil Şabəddin',
            'email'             => 'emil.xankishiyev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);


        // Şirvan regional məntəqəsi
        User::create([
            'stations_id'       => 11,
            'name_surname'      => 'Kərimov Ağaverdi Allahverdi',
            'email'             => 'aghaverdi.karimov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 11,
            'name_surname'      => 'Allahverdiyev Malik Allahverdi',
            'email'             => 'malik.allahverdiyev@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 11,
            'name_surname'      => 'Ismayılov Şahid Rəhim',
            'email'             => 'shahid.ismayilov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Aparıcı mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);


        // Beyləqan regional məntəqəsi
        User::create([
            'stations_id'       => 12,
            'name_surname'      => 'Kərimov Ziya Arif',
            'email'             => 'ziya.karimov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Müdir',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 12,
            'name_surname'      => 'Hüseynov İlham Ulduz',
            'email'             => 'ilham.huseynov@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

        User::create([
            'stations_id'       => 12,
            'name_surname'      => 'Qədirli Nicat Ələsgər',
            'email'             => 'nicat.qadirli@dri.az',
            'contact_number'    => null,
            'type'              => 'user',
            'position'          => 'Mühəndis',
            'password'          => bcrypt('123456'),
            'activity_status'   => 1,
            'ban_start_date'      => NULL,
            'ban_end_date'      => NULL,
            'email_verified_at' => now(),
            'created_at'        => now(),
        ]);

    }
}
