<?php

namespace Database\Seeders;

use App\Models\Frequencies;
use App\Models\ProgramNames;
use App\Models\StationsFrequencies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrequenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            101.3,
            91.9,
            93.9,
            95.9,
            97.9,
            99.3,
            22,
            24,
            26,
            28,
            30,
            32,
            34,
            38,
            40,
            44,
            46,
            47,
            59,
            88.3,
            89,
            90.3,
            90.7,
            91,
            91.8,
            92.3,
            93,
            94.1,
            94.7,
            95,
            95.8,
            96.1,
            97,
            98.3,
            99,
            100.3,
            101,
            102.3,
            103,
            103.8,
            104.3,
            105,
            106.3,
            107,
            21,
            27,
            45,
            89.9,
            99.9,
            101.9,
            103.9,
            43,
            91.1,
            99.1,
            104.7,
            23,
            93.1,
            95.1,
            95.5,
            96.7,
            97.5,
            97.8,
            98.1,
            98.5,
            98.9,
            99.5,
            99.7,
            100.6,
            100.9,
            104.8,
            105.1,
            105.5,
            105.9,
            106.1,
            106.9,
            107.9,
            92.4,
            41,
            53,
            98.4,
            99.4,
            100.1,
            101.8,
            102.7,
            103.7,
            104.9,
            106.8,
            105.7
        ];

        foreach ($array as $item)
        {
//            Frequencies::create([
//                'value'     => $item,
//                'program_names_id' => DB::table('radio')->where(),
//                'directions_id' => ,
//                'program_locations_id' => ,
//                'program_languages_id' => ,
//                'polarizations_id' => ,
//                'status'    => 1
//            ]);
        }
    }
}
