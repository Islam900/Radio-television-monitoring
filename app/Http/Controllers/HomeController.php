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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;

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
        $now = Carbon::now();
        $oneWeeksBefore = $now->copy()->subWeek();
        $daysInRange = Carbon::parse($oneWeeksBefore)->daysUntil($now);

        $days_array = [];
        foreach ($daysInRange as $key => $value) {
            $days_array[] = $value->toDateString();
        }


        $station = Auth::user()->stations;

        //yerli və kənar yayım hesabatlar - tezlikləri ilə birlikdə
        $local_broadcasts = $station->local_broadcasts()->with('frequencies');
        $foreign_broadcasts = $station->foreign_broadcasts()->with('frequencies');

        $local_measurements = [];
        $foreign_measurements = [];

        //yerli ve kenar olcmeler tv ve fm sayi ile birlikde secilen gun araliginda
        foreach ($daysInRange as $key => $value) {
            $local_measurements[] = [
                'date' => $value->toDateString(),
                'TV' => $station->local_broadcasts()
                            ->whereHas('frequencies', function ($query) {
                                $query->where('value', '<', 61);
                            })->where('report_date', $value->toDateString())
                            ->count(),
                'FM' => $station->local_broadcasts()
                            ->whereHas('frequencies', function ($query) {
                                $query->where('value', '>', 60);
                            })->where('report_date', $value->toDateString())
                            ->count()
            ];
        
            $foreign_measurements[] = [
                'date' => $value->toDateString(),
                'TV' => $station->foreign_broadcasts()
                            ->whereHas('frequencies', function ($query) {
                                $query->where('value', '<', 61);
                            })->where('report_date', $value->toDateString())
                            ->count(),
                'FM' => $station->foreign_broadcasts()
                            ->whereHas('frequencies', function ($query) {
                                $query->where('value', '>', 60);
                            })->where('report_date', $value->toDateString())
                            ->count()
            ];
        }

        //yerli olcmelerde umumi tv sayi
        $local_total_tv_count = $station->local_broadcasts()
                                                ->whereHas('frequencies', function ($query) {
                                                    $query->where('value', '<', 61);
                                                })->whereBetween('created_at', [$oneWeeksBefore, $now])
                                                ->count();
        //yerli olcmelerde umumi fm sayi
        $local_total_fm_count = $station->local_broadcasts()
                                                ->whereHas('frequencies', function ($query) {
                                                    $query->where('value', '>', 60);
                                                })->whereBetween('created_at', [$oneWeeksBefore, $now])
                                                ->count();
        //kenar olcmelerde umumi tv sayi
        $foreign_total_tv_count = $station->foreign_broadcasts()
                                                ->whereHas('frequencies', function ($query) {
                                                    $query->where('value', '<', 61);
                                                })->whereBetween('created_at', [$oneWeeksBefore, $now])
                                                ->count();
        //kenar olcmelerde umumi fm sayi
        $foreign_total_fm_count = $station->foreign_broadcasts()
                                                ->whereHas('frequencies', function ($query) {
                                                    $query->where('value', '>', 60);
                                                })->whereBetween('created_at', [$oneWeeksBefore, $now])
                                                ->count();

        //umumi syalarin her birini chartda istifade ucun arrayda toplayiriq 
        $totalFrequencyDataLocal = [
            [
                'value' => $local_total_fm_count,
                'name' => 'FM'
            ],
            [
                'value' => $local_total_tv_count,
                'name' => 'TV'
            ]
        ];

        $totalFrequencyDataForeign = [
            [
                'value' => $foreign_total_fm_count,
                'name' => 'FM'
            ],
            [
                'value' => $foreign_total_tv_count,
                'name' => 'TV'
            ]
        ];


        //menteqenin umumi gore bildiyi maksimum tezlik sayi
        $station_max_frequency_count = $station->frequencies->count();

        //kənar hesabatların istiqamətləri sayı
        $foreign_direction_counts = $foreign_broadcasts->join('directions', 'foreign_broadcasts.directions_id', '=', 'directions.id')
            ->select('directions.name as name', \DB::raw('count(*) as value'))
            ->groupBy('directions_id', 'directions.name')
            ->get()
            ->toArray();

        $directionsData = [];
        foreach ($foreign_direction_counts as $item) {
            $directionsData[] = [
                'value' => $item['value'],
                'name' => $item['name']
            ];
        }

        //kənar hesabatlarda proqramın yayımlandığı yerlərin sayı
        $foreign_locations_counts = $foreign_broadcasts->join('program_locations', 'foreign_broadcasts.program_locations_id', '=', 'program_locations.id')
            ->select('program_locations_id', 'program_locations.name', \DB::raw('count(*) as count'))
            ->groupBy('program_locations_id', 'program_locations.name')
            ->get()
            ->toArray();


        $programLocationsData = [];
        foreach ($foreign_locations_counts as $item) {
            $programLocationsData[] = [
                'value' => $item['count'],
                'name' => $item['name']
            ];
        }

        $foreign_languages_counts = DB::table('foreign_broadcasts')->join('program_languages', 'foreign_broadcasts.program_languages_id', '=', 'program_languages.id')
            ->select('program_languages_id', 'program_languages.name', \DB::raw('count(*) as count'))
            ->groupBy('program_languages_id', 'program_languages.name')
            ->distinct('program_languages_id') // Use distinct method for program_languages_id
            ->get()
            ->toArray();

        $programLanguagesData = [];
        foreach ($foreign_languages_counts as $item) {
            $programLanguagesData[] = [
                'value' => $item->count,
                'name' => $item->name
            ];
        }


        //kənar hesabatlarda qəbul keyfiyyətinə görə qruplaşdırma və say
        $response_quality_counts = $foreign_broadcasts
            ->selectRaw('response_quality, count(*) as count')
            ->groupBy('response_quality')
            ->pluck('count', 'response_quality');

        return view(
            'home',
            compact(
                'days_array',
                'local_measurements',
                'foreign_measurements',
                'totalFrequencyDataLocal',
                'totalFrequencyDataForeign',
                'directionsData',
                'programLocationsData',
                'programLanguagesData',
                'foreign_locations_counts',
                'foreign_languages_counts',
                'response_quality_counts',
                'station_max_frequency_count'
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

}
