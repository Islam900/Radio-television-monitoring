<?php

namespace App\Http\Controllers;

use App\Models\Frequencies;
use App\Models\FrequenciesStations;
use App\Models\LocalBroadcasts;
use App\Models\Logs;
use App\Models\ProgramLocations;
use App\Models\Stations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;
use Pdf;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $start_date = isset ($_GET['start_date']) ? Carbon::parse($_GET['start_date']) : Carbon::now();
        $end_date = isset ($_GET['end_date']) ? Carbon::parse($_GET['end_date']) : $start_date->copy()->addWeek();
        $broadcast = isset ($_GET['broadcast']) ? $_GET['broadcast'] : 'all';



        $longitude = Auth::user()->stations->longitude;
        $latitude = Auth::user()->stations->latitude;
        $response = \Http::get("https://api.openweathermap.org/data/3.0/onecall?lat={$latitude}&lon={$longitude}&appid=154437409d239b216df2e29524abd834");

        if ($response->successful()) {
            $weatherData = $response->json();
            $weatherData = collect($weatherData['daily'])->take(7);
        }

        $daysInRange = Carbon::parse($start_date)->daysUntil($end_date);

        $days_array = [];
        foreach ($daysInRange as $key => $value) {
            $days_array[] = $value->toDateString();
        }

        $station = Auth::user()->stations;

        //yerli və kənar yayım hesabatlar - tezlikləri ilə birlikdə
        $measurements = [];

        // table adini teyin edirik 
        if ($broadcast == 'all') {
            $broadcasts = ['local_broadcasts', 'foreign_broadcasts'];
        } else {
            $broadcasts = [$broadcast];
        }

        // Secilen gun araliginda
        foreach ($daysInRange as $key => $value) {
            $measurements[] = [
                'date' => $value->toDateString(),
                'TV' => 0,
                'FM' => 0
            ];

            foreach ($broadcasts as $b) {
                $measurements[$key]['TV'] += DB::table($b)
                    ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
                    ->where('frequencies.value', '<', 61)
                    ->where('stations_id', $station->id)
                    ->where($b . '.report_date', $value->toDateString())
                    ->count();

                $measurements[$key]['FM'] += DB::table($b)
                    ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
                    ->where('frequencies.value', '>', 60)
                    ->where('stations_id', $station->id)
                    ->where($b . '.report_date', $value->toDateString())
                    ->count();
            }
        }

        $total_fm_count = 0;
        $total_tv_count = 0;

        foreach ($broadcasts as $b) {
            $total_tv_count += DB::table($b)
                ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
                ->where('frequencies.value', '<', 61)
                ->where($b . '.stations_id', $station->id)
                ->whereBetween($b . '.created_at', [$start_date, $end_date])
                ->count() ?? 0;

            $total_fm_count += DB::table($b)
                ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
                ->where('frequencies.value', '>', 60)
                ->where($b . '.stations_id', $station->id)
                ->whereBetween($b . '.created_at', [$start_date, $end_date])
                ->count() ?? 0;
        }



        //umumi syalarin her birini chartda istifade ucun arrayda toplayiriq 
        $totalFrequencyData = [
            [
                'value' => $total_fm_count,
                'name' => 'FM'
            ],
            [
                'value' => $total_tv_count,
                'name' => 'TV'
            ]
        ];


        //menteqenin umumi gore bildiyi maksimum tezlik sayi
        $station_max_frequency_count = $station->frequencies->count() ?? 0;
        $station_max_foreign_broadcasts_count = $station->foreign_broadcasts->count() ?? 0;
        $station_max_local_broadcasts_count = $station->local_broadcasts->count() ?? 0;



        //kənar hesabatların istiqamətləri sayı
        $directions_count = [];

        foreach ($broadcasts as $key => $b) {
            $directions = DB::table($b)
                ->where('stations_id', $station->id)
                ->join('directions', $b . '.directions_id', '=', 'directions.id')
                ->whereBetween($b . '.created_at', [$start_date, $end_date])
                ->select('directions.name as name', DB::raw('count(*) as value'))
                ->groupBy('directions_id', 'directions.name')
                ->get()
                ->toArray() ?? [];

            foreach ($directions as $direction) {
                if (!isset ($directions_count[$direction->name])) {
                    $directions_count[$direction->name] = 0;
                }
                $directions_count[$direction->name] += $direction->value;
            }
        }

        $directionsData = [];

        foreach ($directions_count as $name => $value) {
            $directionsData[] = [
                'value' => $value,
                'name' => $name
            ];
        }


        //kənar hesabatlarda proqramın yayımlandığı yerlərin sayı
        $locations_count = [];

        foreach ($broadcasts as $key => $b) {
            if ($b === 'foreign_broadcasts') {
                $program_locations = DB::table($b)
                    ->where('stations_id', $station->id)
                    ->join('program_locations', $b . '.program_locations_id', '=', 'program_locations.id')
                    ->whereBetween($b . '.created_at', [$start_date, $end_date])
                    ->select('program_locations.name as name', DB::raw('count(*) as value'))
                    ->groupBy('program_locations_id', 'program_locations.name')
                    ->get()
                    ->toArray() ?? [];

                foreach ($program_locations as $location) {
                    if (!isset ($locations_count[$location->name])) {
                        $locations_count[$location->name] = 0;
                    }
                    $locations_count[$location->name] += $location->value;
                }
            }
        }

        $programLocationsData = [];

        foreach ($locations_count as $name => $value) {
            $programLocationsData[] = [
                'value' => $value,
                'name' => $name
            ];
        }


        $languages_count = [];

        foreach ($broadcasts as $key => $b) {
            $program_languages = DB::table($b)
                ->where('stations_id', $station->id)
                ->join('program_languages', $b . '.program_languages_id', '=', 'program_languages.id')
                ->whereBetween($b . '.created_at', [$start_date, $end_date])
                ->select('program_languages.name as name', DB::raw('count(*) as value'))
                ->groupBy('program_languages_id', 'program_languages.name')
                ->get()
                ->toArray() ?? [];

            foreach ($program_languages as $language) {
                if (!isset ($languages_count[$language->name])) {
                    $languages_count[$language->name] = 0;
                }
                $languages_count[$language->name] += $language->value;
            } 
        }

        $programLanguagesData = [];

        foreach ($languages_count as $name => $value) {
            $programLanguagesData[] = [
                'value' => $value,
                'name' => $name
            ];
        }

        

        $emfs = [];
        foreach (DB::table('foreign_broadcasts')->where('stations_id', $station->id)->where('frequencies_id', 7)->get() as $key => $value) {
            $emfs[$key]['in'] = $value->emfs_level_in;
            $emfs[$key]['out'] = $value->emfs_level_out ?? 0;
            $emfs[$key]['report_date'] = $value->report_date;
        }




        //kənar hesabatlarda qəbul keyfiyyətinə görə qruplaşdırma və say
        $response_quality_counts = [];

        foreach ($broadcasts as $key => $b) {
            $response_quality = DB::table($b)
                ->where('stations_id', $station->id)
                ->whereBetween($b . '.created_at', [$start_date, $end_date])
                ->selectRaw('response_quality, count(*) as count')
                ->groupBy('response_quality')
                ->pluck('count', 'response_quality')
                ->toArray();
        
            foreach (['Vurulur', 'Yaxşı', 'Kafi', 'Zəif'] as $quality) {
                $response_quality_counts[$quality] = $response_quality[$quality] ?? 0;
            }
        }
        
        if (empty($response_quality_counts)) {
            $response_quality_counts = [
                'Vurulur' => 0,
                'Yaxşı' => 0,
                'Kafi' => 0,
                'Zəif' => 0,
            ];
        }
        
        $periodik_say = 0;
        $daimi_say = 0;

        foreach ($broadcasts as $key => $b) {
            if ($b === 'foreign_broadcasts') {
                $periodik_say += DB::table('foreign_broadcasts')->where('stations_id', $station->id)
                    ->where('response_quality', 'Vurulur')
                    ->where('cons_or_peri', 'Periodik')
                    ->whereBetween($b . '.created_at', [$start_date, $end_date])
                    ->count() ?? 0;

                $daimi_say += DB::table('foreign_broadcasts')->where('stations_id', $station->id)
                    ->where('response_quality', 'Vurulur')
                    ->where('cons_or_peri', 'Daimi')
                    ->whereBetween($b . '.created_at', [$start_date, $end_date])
                    ->count() ?? 0;
            }
        }

        return view(
            'home',
            compact(
                'measurements',
                'totalFrequencyData',
                'station_max_frequency_count',
                'station_max_foreign_broadcasts_count',
                'station_max_local_broadcasts_count',
                'directionsData',
                'programLocationsData',
                'programLanguagesData',
                'emfs',
                'response_quality_counts',
                'periodik_say',
                'daimi_say',
                'weatherData'
            )
        );

    }


    public function station_profile()
    {
        $coordinate_N = Auth::user()->stations->coordinate_N;
        $coordinate_E = Auth::user()->stations->coordinate_E;

        $n = preg_split("/°|\"|'/", $coordinate_N, -1, PREG_SPLIT_NO_EMPTY);
        $e = preg_split("/°|\"|'/", $coordinate_E, -1, PREG_SPLIT_NO_EMPTY);



        return view('settings.profile', compact('n', 'e'));
    }

    public function update_station_profile(Request $request, $id)
    {
        (new LogsController())->create_logs(Auth::user()->name_surname . ' hesab məlumatlarında düzəliş etdi.');

        $validator = Validator::make($request->all(), [
            'name_surname' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Session::flash('errors', $errors);
            return redirect()->back();
        }

        $data = $request->all();

        $user = User::find($id);
        if ($request->password) {
            if (bcrypt($request->new_password) == Auth::user()->password) {
                return redirect()->route('station-profile')
                    ->with('error', 'Daxil etdiyiniz yeni şifrə mövcud şifrə ilə eynidir!');
            } elseif (bcrypt($request->password) != Auth::user()->password) {
                return redirect()->route('station-profile')
                    ->with('error', 'Mövcud şifrəni düzgün daxil etməmisiniz!');
            } else {
                $data['password'] = bcrypt($request->new_password);
            }
            $user->password = $data['password'];
        }

        $user->name_surname = $request->name_surname;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->save();

        return redirect()->route('station-profile')
            ->with('success', 'Məlumatlar müvəffəqiyyətlə dəyişdirildi.');
    }

    public function get_data_by_frequency(Request $request)
    {
        $frequency = Auth::user()->stations()->first()->frequencies()->where('value', $request->frequencies_id)->first();
        $frequency_data = $frequency->load('program_names', 'program_languages', 'directions', 'polarizations', 'program_locations');
        return $frequency_data;
    }

    public function export_to_pdf(Request $request)
    {

        // $start_date = $request->start_date;
        // $end_date = $request->end_date;
        // $broadcast = $request->broadcast;



        // $longitude = Auth::user()->stations->longitude;
        // $latitude = Auth::user()->stations->latitude;
        // $response = \Http::get("https://api.openweathermap.org/data/3.0/onecall?lat={$latitude}&lon={$longitude}&appid=154437409d239b216df2e29524abd834");

        // if ($response->successful()) {
        //     $weatherData = $response->json();
        //     $weatherData = collect($weatherData['daily'])->take(7);
        // }

        // $daysInRange = Carbon::parse($start_date)->daysUntil($end_date);

        // $days_array = [];
        // foreach ($daysInRange as $key => $value) {
        //     $days_array[] = $value->toDateString();
        // }

        // $station = Auth::user()->stations;

        // //yerli və kənar yayım hesabatlar - tezlikləri ilə birlikdə
        // $measurements = [];

        // // table adini teyin edirik 
        // if ($broadcast == 'all') {
        //     $broadcasts = ['local_broadcasts', 'foreign_broadcasts'];
        // } else {
        //     $broadcasts = [$broadcast];
        // }

        // // Secilen gun araliginda
        // foreach ($daysInRange as $key => $value) {
        //     $measurements[] = [
        //         'date' => $value->toDateString(),
        //         'TV' => 0,
        //         'FM' => 0
        //     ];

        //     foreach ($broadcasts as $b) {
        //         $measurements[$key]['TV'] += DB::table($b)
        //             ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
        //             ->where('frequencies.value', '<', 61)
        //             ->where('stations_id', $station->id)
        //             ->where($b . '.report_date', $value->toDateString())
        //             ->count();

        //         $measurements[$key]['FM'] += DB::table($b)
        //             ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
        //             ->where('frequencies.value', '>', 60)
        //             ->where('stations_id', $station->id)
        //             ->where($b . '.report_date', $value->toDateString())
        //             ->count();
        //     }
        // }

        // $total_fm_count = 0;
        // $total_tv_count = 0;

        // foreach ($broadcasts as $b) {
        //     $total_tv_count += DB::table($b)
        //         ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
        //         ->where('frequencies.value', '<', 61)
        //         ->where($b . '.stations_id', $station->id)
        //         ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //         ->count() ?? 0;

        //     $total_fm_count += DB::table($b)
        //         ->join('frequencies', $b . '.frequencies_id', '=', 'frequencies.id')
        //         ->where('frequencies.value', '>', 60)
        //         ->where($b . '.stations_id', $station->id)
        //         ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //         ->count() ?? 0;
        // }



        // //umumi syalarin her birini chartda istifade ucun arrayda toplayiriq 
        // $totalFrequencyData = [
        //     [
        //         'value' => $total_fm_count,
        //         'name' => 'FM'
        //     ],
        //     [
        //         'value' => $total_tv_count,
        //         'name' => 'TV'
        //     ]
        // ];


        // //menteqenin umumi gore bildiyi maksimum tezlik sayi
        // $station_max_frequency_count = $station->frequencies->count() ?? 0;
        // $station_max_foreign_broadcasts_count = $station->foreign_broadcasts->count() ?? 0;
        // $station_max_local_broadcasts_count = $station->local_broadcasts->count() ?? 0;



        // //kənar hesabatların istiqamətləri sayı
        // $directions_count = [];

        // foreach ($broadcasts as $key => $b) {
        //     $directions = DB::table($b)
        //         ->where('stations_id', $station->id)
        //         ->join('directions', $b . '.directions_id', '=', 'directions.id')
        //         ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //         ->select('directions.name as name', DB::raw('count(*) as value'))
        //         ->groupBy('directions_id', 'directions.name')
        //         ->get()
        //         ->toArray() ?? [];

        //     foreach ($directions as $direction) {
        //         if (!isset ($directions_count[$direction->name])) {
        //             $directions_count[$direction->name] = 0;
        //         }
        //         $directions_count[$direction->name] += $direction->value;
        //     }
        // }

        // $directionsData = [];

        // foreach ($directions_count as $name => $value) {
        //     $directionsData[] = [
        //         'value' => $value,
        //         'name' => $name
        //     ];
        // }


        // //kənar hesabatlarda proqramın yayımlandığı yerlərin sayı
        // $locations_count = [];

        // foreach ($broadcasts as $key => $b) {
        //     if ($b === 'foreign_broadcasts') {
        //         $program_locations = DB::table($b)
        //             ->where('stations_id', $station->id)
        //             ->join('program_locations', $b . '.program_locations_id', '=', 'program_locations.id')
        //             ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //             ->select('program_locations.name as name', DB::raw('count(*) as value'))
        //             ->groupBy('program_locations_id', 'program_locations.name')
        //             ->get()
        //             ->toArray() ?? [];

        //         foreach ($program_locations as $location) {
        //             if (!isset ($locations_count[$location->name])) {
        //                 $locations_count[$location->name] = 0;
        //             }
        //             $locations_count[$location->name] += $location->value;
        //         }
        //     }
        // }

        // $programLocationsData = [];

        // foreach ($locations_count as $name => $value) {
        //     $programLocationsData[] = [
        //         'value' => $value,
        //         'name' => $name
        //     ];
        // }


        // $languages_count = [];

        // foreach ($broadcasts as $key => $b) {
        //     $program_languages = DB::table($b)
        //         ->where('stations_id', $station->id)
        //         ->join('program_languages', $b . '.program_languages_id', '=', 'program_languages.id')
        //         ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //         ->select('program_languages.name as name', DB::raw('count(*) as value'))
        //         ->groupBy('program_languages_id', 'program_languages.name')
        //         ->get()
        //         ->toArray() ?? [];

        //     foreach ($program_languages as $language) {
        //         if (!isset ($languages_count[$language->name])) {
        //             $languages_count[$language->name] = 0;
        //         }
        //         $languages_count[$language->name] += $language->value;
        //     } 
        // }

        // $programLanguagesData = [];

        // foreach ($languages_count as $name => $value) {
        //     $programLanguagesData[] = [
        //         'value' => $value,
        //         'name' => $name
        //     ];
        // }

        

        // $emfs = [];
        // foreach (DB::table('foreign_broadcasts')->where('stations_id', $station->id)->where('frequencies_id', 7)->get() as $key => $value) {
        //     $emfs[$key]['in'] = $value->emfs_level_in;
        //     $emfs[$key]['out'] = $value->emfs_level_out ?? 0;
        //     $emfs[$key]['report_date'] = $value->report_date;
        // }




        // //kənar hesabatlarda qəbul keyfiyyətinə görə qruplaşdırma və say
        // $response_quality_counts = [];

        // foreach ($broadcasts as $key => $b) {
        //     $response_quality = DB::table($b)
        //         ->where('stations_id', $station->id)
        //         ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //         ->selectRaw('response_quality, count(*) as count')
        //         ->groupBy('response_quality')
        //         ->pluck('count', 'response_quality')
        //         ->toArray();
        
        //     foreach (['Vurulur', 'Yaxşı', 'Kafi', 'Zəif'] as $quality) {
        //         $response_quality_counts[$quality] = $response_quality[$quality] ?? 0;
        //     }
        // }
        
        // if (empty($response_quality_counts)) {
        //     $response_quality_counts = [
        //         'Vurulur' => 0,
        //         'Yaxşı' => 0,
        //         'Kafi' => 0,
        //         'Zəif' => 0,
        //     ];
        // }
        
        // $periodik_say = 0;
        // $daimi_say = 0;

        // foreach ($broadcasts as $key => $b) {
        //     if ($b === 'foreign_broadcasts') {
        //         $periodik_say += DB::table('foreign_broadcasts')->where('stations_id', $station->id)
        //             ->where('response_quality', 'Vurulur')
        //             ->where('cons_or_peri', 'Periodik')
        //             ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //             ->count() ?? 0;

        //         $daimi_say += DB::table('foreign_broadcasts')->where('stations_id', $station->id)
        //             ->where('response_quality', 'Vurulur')
        //             ->where('cons_or_peri', 'Daimi')
        //             ->whereBetween($b . '.created_at', [$start_date, $end_date])
        //             ->count() ?? 0;
        //     }
        // }

        
        //     $data['measurements'] = $measurements;
        //     $data['totalFrequencyData'] = $totalFrequencyData;
        //     $data['station_max_frequency_count'] = $station_max_frequency_count;
        //     $data['station_max_foreign_broadcasts_count'] = $station_max_foreign_broadcasts_count;
        //     $data['station_max_local_broadcasts_count'] = $station_max_local_broadcasts_count;
        //     $data['directionsData'] = $directionsData;
        //     $data['programLocationsData'] = $programLocationsData;
        //     $data['programLanguagesData'] = $programLanguagesData;
        //     $data['emfs'] = $emfs;
        //     $data['response_quality_counts'] = $response_quality_counts;
        //     $data['periodik_say'] = $periodik_say;
        //     $data['daimi_say'] = $daimi_say;

            $mytime = Carbon::now()->addHours(4);
            $data = $request;
            $pdf = PDF::loadView('statistics', ['data' => $data, 'mytime' => $mytime]);
            $path = public_path('documents/');
            $fileName = 'asda123123ap.' . 'pdf';
            $pdf->save($path . '/' . $fileName);
            // $pdf = base64_encode($pdff->output());
            // file_put_contents($path.$PdfName, $pdf);
            return $fileName;



            // $pdf = Pdf::loadView('statistics', ['data' => 'data']);
            // // dd($pdf);
            // return $pdf->download('statistics.pdf');

    }

}
