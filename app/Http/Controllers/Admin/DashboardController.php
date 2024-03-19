<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $now = Carbon::now();
        $oneWeeksBefore = $now->copy()->subWeek();
        $daysInRange = Carbon::parse($oneWeeksBefore)->daysUntil($now);

        $days_array = [];
        foreach ($daysInRange as $key => $value) {
            $days_array[] = $value->toDateString();
        }



        //yerli və kənar yayım hesabatlar - tezlikləri ilə birlikdə
        $local_measurements = [];
        $foreign_measurements = [];

        //yerli ve kenar olcmeler tv ve fm sayi ile birlikde secilen gun araliginda
        foreach ($daysInRange as $key => $value) {
            $local_measurements[] = [
                'date' => $value->toDateString(),
                'TV' => DB::table('local_broadcasts')
                            ->join('frequencies', 'local_broadcasts.frequencies_id', '=', 'frequencies.id')
                            ->where('frequencies.value', '<', 61)
                            
                            ->where('local_broadcasts.report_date', $value->toDateString())
                            ->count(),
                'FM' => DB::table('local_broadcasts')
                            ->join('frequencies', 'local_broadcasts.frequencies_id', '=', 'frequencies.id')
                            ->where('frequencies.value', '>', 60)
                            
                            ->where('local_broadcasts.report_date', $value->toDateString())
                            ->count()
            ];
        
            $foreign_measurements[] = [
                'date' => $value->toDateString(),
                'TV' => DB::table('foreign_broadcasts')
                            ->join('frequencies', 'foreign_broadcasts.frequencies_id', '=', 'frequencies.id')
                            ->where('frequencies.value', '<', 61)
                            
                            ->where('foreign_broadcasts.report_date', $value->toDateString())
                            ->count(),
                'FM' => DB::table('foreign_broadcasts')
                            ->join('frequencies', 'foreign_broadcasts.frequencies_id', '=', 'frequencies.id')
                            ->where('frequencies.value', '>', 60)
                            
                            ->where('foreign_broadcasts.report_date', $value->toDateString())
                            ->count()
            ];
        }

        //yerli olcmelerde umumi tv sayi
        $local_total_tv_count = DB::table('local_broadcasts')
            ->join('frequencies', 'local_broadcasts.frequencies_id', '=', 'frequencies.id')
            ->where('frequencies.value', '<', 61)
            
            ->whereBetween('local_broadcasts.created_at', [$oneWeeksBefore, $now])
            ->count();

        $local_total_fm_count = DB::table('local_broadcasts')
            ->join('frequencies', 'local_broadcasts.frequencies_id', '=', 'frequencies.id')
            ->where('frequencies.value', '>', 60)
            
            ->whereBetween('local_broadcasts.created_at', [$oneWeeksBefore, $now])
            ->count();

        $foreign_total_tv_count = DB::table('foreign_broadcasts')
            ->join('frequencies', 'foreign_broadcasts.frequencies_id', '=', 'frequencies.id')
            ->where('frequencies.value', '<', 61)
            
            ->whereBetween('foreign_broadcasts.created_at', [$oneWeeksBefore, $now])
            ->count();

        $foreign_total_fm_count = DB::table('foreign_broadcasts')
            ->join('frequencies', 'foreign_broadcasts.frequencies_id', '=', 'frequencies.id')
            ->where('frequencies.value', '>', 60)
            
            ->whereBetween('foreign_broadcasts.created_at', [$oneWeeksBefore, $now])
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
        $station_max_frequency_count = DB::table('frequencies')->count();
        $station_max_foreign_broadcasts_count = DB::table('foreign_broadcasts')->count();
        $station_max_local_broadcasts_count = DB::table('local_broadcasts')->count();

        //kənar hesabatların istiqamətləri sayı
        $foreign_direction_counts = DB::table('foreign_broadcasts')->join('directions', 'foreign_broadcasts.directions_id', '=', 'directions.id')
            ->select('directions.name as name', \DB::raw('count(*) as value'))
            ->groupBy('directions_id', 'directions.name')
            ->get()
            ->toArray();

        $directionsData = [];
        foreach ($foreign_direction_counts as $item) {
            $directionsData[] = [
                'value' => $item->value,
                'name' => $item->name
            ];
        }

        //kənar hesabatlarda proqramın yayımlandığı yerlərin sayı
        $foreign_locations_counts =  DB::table('foreign_broadcasts')->join('program_locations', 'foreign_broadcasts.program_locations_id', '=', 'program_locations.id')
            ->select('program_locations_id', 'program_locations.name', \DB::raw('count(*) as count'))
            ->groupBy('program_locations_id', 'program_locations.name')
            ->get()
            ->toArray();

        $programLocationsData = [];
        foreach ($foreign_locations_counts as $item) {
            $programLocationsData[] = [
                'value' => $item->count,
                'name' => $item->name
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

       
            
        $emfs = [];
        foreach (DB::table('foreign_broadcasts')->where('frequencies_id', 7)->get() as $key => $value) {
            $emfs[$key]['in'] = $value->emfs_level_in;
            $emfs[$key]['out'] = $value->emfs_level_out ?? 0;
            $emfs[$key]['report_date'] = $value->report_date;
        }

        


        //kənar hesabatlarda qəbul keyfiyyətinə görə qruplaşdırma və say
        $response_quality_counts = DB::table('foreign_broadcasts')
            ->selectRaw('response_quality, count(*) as count')
            ->groupBy('response_quality')
            ->pluck('count', 'response_quality');


        $periodik_say = DB::table('foreign_broadcasts')
            ->where('response_quality', 'Vurulur')
            ->where('cons_or_peri', 'Periodik')
            ->count();
    
        $daimi_say = DB::table('foreign_broadcasts')
            ->where('response_quality', 'Vurulur')
            ->where('cons_or_peri', 'Daimi')
            ->count();

        return view(
            'admin.dashboard',
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
                'station_max_frequency_count',
                'emfs',
                'periodik_say',
                'daimi_say',
                'station_max_foreign_broadcasts_count',
                'station_max_local_broadcasts_count',
            )
        );
    }

    public function logs()
    {
        $logs = Logs::orderBy('id', 'DESC')->get();
        return view('admin.logs', compact('logs'));
    }
}
