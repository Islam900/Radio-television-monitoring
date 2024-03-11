<?php

namespace Database\Seeders;

use App\Models\Stations;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $station1 = Stations::create(
            [
                'station_name' => 'Bakı şəhəri üzrə 1 saylı məntəqə (Mehdiabad)',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------

        $station2 = Stations::create(
            [
                'station_name' => 'Bakı şəhəri üzrə 2 saylı məntəqə (Yasamal)',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------


        $station3 = Stations::create(
            [
                'station_name' => 'Bakı şəhəri üzrə 3 saylı məntəqə (Günəşli)',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------


        $station4 = Stations::create(
            [
                'station_name' => 'Gəncə regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------

        $station5 = Stations::create(
            [
                'station_name' => 'Qazax regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------

        $station6 = Stations::create(
            [
                'station_name' => 'Qəbələ regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------


        Stations::create(
            [
                'station_name' => 'Zaqatala regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------


        Stations::create(
            [
                'station_name' => 'Quba regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );


        // -----------------------------------------------------------------------------------------------------


        Stations::create(
            [
                'station_name' => 'Masallı regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );


        // -----------------------------------------------------------------------------------------------------


        Stations::create(
            [
                'station_name' => 'Astara regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );


        // -----------------------------------------------------------------------------------------------------


        Stations::create(
            [
                'station_name' => 'Şirvan regional məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );


        // -----------------------------------------------------------------------------------------------------


        Stations::create(
            [
                'station_name' => 'Beyləqan regional  məntəqəsi',
                'coordinate_N' => '',
                'coordinate_E' => ''
            ]
        );

        // -----------------------------------------------------------------------------------------------------
    }
}
