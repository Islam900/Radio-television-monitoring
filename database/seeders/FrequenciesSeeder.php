<?php

namespace Database\Seeders;

use App\Models\Frequencies;
use App\Models\FrequenciesStations;
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
        $array = DB::table('radio')
            ->distinct()
            ->select('station_id','frequency_id', 'program_name', 'direction', 'program_location', 'program_language')
            ->get();

        foreach ($array as $item) {
            $programName = DB::table('program_names')->where('name', $item->program_name)->value('id');
            $direction = DB::table('directions')->where('name', $item->direction)->value('id');
            $programLocation = DB::table('program_locations')->where('name', $item->program_location)->value('id');
            $programLanguage = DB::table('program_languages')->where('name', $item->program_language)->value('id');
            $station_id = DB::table('stations')->where('station_name', 'LIKE',"%{$item->station_id}%")->value('id');

            $tezlik = Frequencies::create([
                'value'               => $item->frequency_id,
                'program_names_id'    => $programName ?? NULL,
                'directions_id'       => $direction ?? NULL,
                'program_locations_id'=> $programLocation ?? NULL,
                'program_languages_id'=> $programLanguage ?? NULL,
                'polarizations_id'    => is_int($item) ? 1 : 2,
                'status'              => 1
            ]);

            FrequenciesStations::create([
                'frequencies_id' => $tezlik->id,
                'stations_id' => $station_id
            ]);

        }
    }
}
