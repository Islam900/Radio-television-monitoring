<?php

namespace App\Http\Controllers;

use App\Models\ForeignBroadcasts;
use App\Models\Frequencies;
use App\Models\FrequenciesStations;
use App\Models\Logs;
use App\Models\Notifications;
use App\Models\Stations;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ForeignBroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Auth::user()->stations->foreign_broadcasts;
        return view('foreign-broadcasts.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $station = Stations::find(Auth::user()->stations_id);
        $frequencies = $station->frequencies()->distinct()->get();
        $devices = config('data.devices');
        $options = config('data.options');
        return view('foreign-broadcasts.create', compact('frequencies', 'devices', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $submitDate = Carbon::now()->format('Y-m-d');
        $frequencies = Frequencies::pluck('value')->toArray();
        $stations_id = Auth::user()->stations_id;
        $report_date = $submitDate;
        $report_number = "FR-" . rand(0, 999999);
        foreach ($request->frequencies_id as $key => $local_frequency) {
            if (!in_array((float) $local_frequency, $frequencies)) {
                $frequency = Frequencies::create([
                    'value' => $local_frequency
                ]);

                FrequenciesStations::create([
                    'frequencies_id' => $frequency->id,
                    'stations_id' => Auth::user()->stations_id
                ]);

                $fr_id = $frequency->id;
            } else {
                $fr_id = Frequencies::where('value', $local_frequency)->first()->id;
            }

            $foreign = ForeignBroadcasts::create([
                'report_number' => $report_number,
                'stations_id' => $stations_id,
                'report_date' => $report_date,
                'frequencies_id' => $fr_id,
                'program_names_id' => $request->program_names_id[$key],
                'directions_id' => $request->directions_id[$key],
                'program_languages_id' => $request->program_languages_id[$key],
                'program_locations_id' => $request->program_locations_id[$key],
                'emfs_level_in' => $request->emfs_level_in[$key],
                'emfs_level_out' => $request->emfs_level_out[$key] ?? NULL,
                'response_direction_in' => $request->response_direction_in[$key],
                'response_direction_out' => $request->response_direction_out[$key] ?? NULL,
                'polarization' => $request->polarization[$key],
                'response_quality' => $request->response_quality[$key],
                'sending_from' => $request->sending_from[$key] ?? NULL,
                'cons_or_peri' => $request->cons_or_peri[$key] ?? NULL,
                'device' => implode(',', array_keys($request->device)),
                'note' => $request->note
            ]);
        }

        Notifications::create([
            'sender' => Auth::user()->stations->station_name,
            'receiver' => 'admin',
            'lr_id' => $foreign->id,
            'content' => $submitDate . ' tarixi üçün ' . Auth::user()->stations->station_name . ' tərəfindən kənar ölçmələrin hesabatı sistemə daxil olundu.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        (new LogsController())->create_logs(Auth::user()->name_surname . ' ' . Auth::user()->stations->station_name . ' üçün kənar ölçmələrin gündəlik hesabatını sistemə daxil etdi.');

        return response()->json([
            'title' => 'Məlumatlar sistemə daxil edildi.',
            'message' => $submitDate . ' tarixi üçün məlumatlar sistemə daxil edildi.',
            'route' => route('foreign-broadcasts.index'),
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ForeignBroadcasts $foreignBroadcast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForeignBroadcasts $foreignBroadcast)
    {
        $foreignBroadcast->load('frequencies.program_languages', 'frequencies.program_names', 'frequencies.directions', 'frequencies.polarizations', 'frequencies.program_locations');

        $frequencies = $foreignBroadcast->frequencies;
        $program_languages = $frequencies->program_languages;
        $program_names = $frequencies->program_names;
        $directions = $frequencies->directions;
        $polarizations = $frequencies->polarizations;
        $program_locations = $frequencies->program_locations;

        $devices = config('data.devices');
        $options = config('data.options');
        return view('foreign-broadcasts.edit', compact('foreignBroadcast', 'frequencies', 'polarizations', 'program_locations', 'program_languages', 'program_names', 'directions', 'devices', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForeignBroadcasts $foreignBroadcast)
    {
        $data = $request->all();
        $frequencies = Frequencies::pluck('value')->toArray();
        if (!in_array((float) $request->frequencies_id, $frequencies)) {
            $frequency = Frequencies::create([
                'value' => $request->frequencies_id
            ]);

            FrequenciesStations::create([
                'frequencies_id' => $frequency->id,
                'stations_id' => Auth::user()->stations_id
            ]);
            $data['frequencies_id'] = $frequency->id;
        } else {
            $data['frequencies_id'] = Frequencies::where('value', $request->frequencies_id)->first()->id;
        }
        $data['device'] = implode(',', array_keys($request->device));
        $foreignBroadcast->accepted_status = 0;
        $foreignBroadcast->update($data);
        $foreignBroadcast->save();

        $foreignBroadcast->edit_reasons->last()->update([
            'solved_status' => 1
        ]);

        Notifications::create([
            'sender' => Auth::user()->stations->station_name,
            'receiver' => 'admin',
            'lr_id' => $foreignBroadcast->id,
            'content' => $foreignBroadcast->report_date . ' tarixi üçün ' . Auth::user()->stations->station_name . ' tərəfindən daxil edilən kənar ölçmələrin hesabatı düzəliş edildikdən sonra təsdiq üçün göndərildi.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        (new LogsController())->create_logs(Auth::user()->name_surname . ' ' . Auth::user()->stations->station_name . ' üçün verilən ' . $foreignBroadcast->report_number . ' nömrəli ölçmələrin gündəlik hesabatında düzəliş etdi.');

        return response()->json([
            'message' => 'Məlumatlar yenilənib təsdiq üçün göndərildi.',
            'route' => route('foreign-broadcasts.index'),
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForeignBroadcasts $foreignBroadcast)
    {
        //
    }
}
