<?php

namespace Database\Seeders;

use App\Models\Frequencies;
use App\Models\FrequenciesStations;
use App\Models\ProgramNames;
use App\Models\Stations;
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



        $stations = Stations::all();

        foreach ($stations as $station) {
            $array = DB::table('radio')
                ->where('station_id', $station->station_name)
                ->pluck('frequency_id')
                ->toArray();

            foreach ($array as $item) {

                $tezlik = Frequencies::create([
                    'value' => $item,
                    'program_names_id' => NULL,
                    'directions_id' => NULL,
                    'program_locations_id' => NULL,
                    'program_languages_id' => NULL,
                    'polarizations_id' => $item <= 60 ? 1 : 2,
                    'status' => 1
                ]);

                $ff = FrequenciesStations::create([
                    'frequencies_id' => $tezlik->id,
                    'stations_id' => $station->id
                ]);

                $programName = DB::table('program_names')
                    ->where('name', function ($query) use ($item, $station) {
                        $query->from('radio')
                            ->select('program_name')
                            ->where('frequency_id', $item)
                            ->where('station_id', $station->station_name)
                            ->orderBy('id')
                            ->limit(1);
                    })
                    ->value('id');

                $direction = DB::table('directions')->where('name', function ($query) use ($item, $station) {
                    $query->from('radio')
                        ->select('direction')
                        ->where('frequency_id', $item)
                        ->where('station_id', $station->station_name)
                        ->orderBy('id')
                        ->limit(1);
                })
                    ->value('id');

                $programLocation = DB::table('program_locations')->where('name', function ($query) use ($item, $station) {
                    $query->from('radio')
                        ->select('program_location')
                        ->where('frequency_id', $item)
                        ->where('station_id', $station->station_name)
                        ->orderBy('id')
                        ->limit(1);
                })
                    ->value('id');

                $programLanguage = DB::table('program_languages')->where('name', function ($query) use ($item, $station) {
                    $query->from('radio')
                        ->select('program_language')
                        ->where('frequency_id', $item)
                        ->where('station_id', $station->station_name)
                        ->orderBy('id')
                        ->limit(1);
                })
                    ->value('id');

                $tezlik->program_names_id = $programName ?? NULL;
                $tezlik->directions_id = $direction ?? NULL;
                $tezlik->program_locations_id = $programLocation ?? NULL;
                $tezlik->program_languages_id = $programLanguage ?? NULL;
                $tezlik->save();
            }
        }
    }
}
