<?php

namespace Database\Seeders;

use App\Models\ProgramLocations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'Təyin edilmədi',
            'Zibakenar',
            'Astara (gln)',
            'Kuh-e Sangar',
            'Talesh (gln)',
            'Kuh-e Sangar (gln)',
            'Zibakenar (gln)',
            'Kuh-e Sangar (ard)',
            'Moghan',
            'Moghan və Parsabad',
            'Kakheti, Dedoplistskaro',
            'Kakheti, Telavi',
            'Kakheti, Gurjaani ',
            'Tbilisi, Mtazminda ',
            'Tbilisi',
            'Sevkar, Tavush',
            'Tbilisi, Mtazminda',
            'Rustavi/Hotel Rustavi',
            'Tbilisi ',
            'Tbilisi, Vake West',
            'Tbilisi/Vake',
            'Rustavi, Kvemo Kartli ',
            'Chinchin, Tavush',
            'Voskepar (Əksipara), Tavush',
            'Tbilisi, Makhata Mountain',
            'Armenia Sunik',
            'Rusiya',
            'Derbend',
            'Derbend  RTS Dzhalgan ',
            'Mayak',
            'İran',
            'Kuh-e Sangar və Parsabad',
            'Dedoplistskaro',
            'Telavi\Tsivi',
            'Kvareli'
        ];

        foreach ($array as $item)
        {
            ProgramLocations::create([
                'name' => $item,
                'status' => 1
            ]);
        }
    }
}
