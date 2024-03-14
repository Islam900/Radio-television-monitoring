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
        $array = DB::table('radio')
            ->distinct()
            ->pluck('frequency_id')
            ->toArray();

            foreach ($array as $item) {
                $programName = DB::table('program_names')
                            ->where('name', function ($query) use ($item) {
                                $query->from('radio')
                                      ->select('program_name')
                                      ->where('frequency_id', $item)
                                      ->orderBy('id')
                                      ->limit(1);
                            })
                            ->value('id');
                $direction = DB::table('directions')->where('name', function ($query) use ($item) {
                                $query->from('radio')
                                      ->select('direction')
                                      ->where('frequency_id', $item)
                                      ->orderBy('id')
                                      ->limit(1);
                            })
                            ->value('id');

                $programLocation = DB::table('program_locations')->where('name', function ($query) use ($item) {
                                        $query->from('radio')
                                              ->select('program_location')
                                              ->where('frequency_id', $item)
                                              ->orderBy('id')
                                              ->limit(1);
                                    })
                                    ->value('id');

                $programLanguage = DB::table('program_languages')->where('name', function ($query) use ($item) {
                                        $query->from('radio')
                                              ->select('program_language')
                                              ->where('frequency_id', $item)
                                              ->orderBy('id')
                                              ->limit(1);
                                    })
                                    ->value('id');


                $tezlik = Frequencies::create([
                    'value'               => $item,
                    'program_names_id'    => $programName ?? NULL,
                    'directions_id'       => $direction ?? NULL,
                    'program_locations_id'=> $programLocation ?? NULL,
                    'program_languages_id'=> $programLanguage ?? NULL,
                    'polarizations_id'    => is_int($item) ? 1 : 2,
                    'status'              => 1
                ]);
            }

            $stations = Stations::all();

            foreach($stations as $station)
            {
                $radio_frequencies = DB::table('radio')->where('station_id', $station->station_name)->get();
                foreach ($radio_frequencies as $frequency)
                {
                    FrequenciesStations::create([
                        'frequencies_id' => Frequencies::where('value', $frequency->frequency_id)->value('id'),
                        'stations_id'    => $station->id
                    ]);
                }
            }
    }
}
