<?php

namespace App\Http\Controllers;

use App\Models\Frequencies;
use App\Models\FrequenciesStations;
use App\Models\LocalBroadcasts;
use App\Models\Logs;
use App\Models\Notifications;
use App\Models\Stations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LocalBroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Auth::user()->stations->local_broadcasts;
        return view('local-broadcasts.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $station = Stations::find(Auth::user()->stations_id);
        $frequencies = $station->frequencies()->distinct()->get();
        $devices = config('data.devices');
        return view('local-broadcasts.create', compact('frequencies', 'devices'));
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
        $report_number = "LR-" . rand(0, 999999);
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

            $local = LocalBroadcasts::create([
                'report_number' => $report_number,
                'stations_id' => $stations_id,
                'report_date' => $report_date,
                'frequencies_id' => $fr_id,
                'program_names_id' => $request->program_names_id[$key],
                'directions_id' => $request->directions_id[$key],
                'program_languages_id' => $request->program_languages_id[$key],
                'emfs_level' => $request->emfs_level[$key],
                'response_direction' => $request->response_direction[$key],
                'polarization' => $request->polarization[$key],
                'response_quality' => $request->response_quality[$key],
                'device' => implode(',', array_keys($request->device)),
                'note' => $request->note
            ]);
        }


        Notifications::create([
            'sender' => Auth::user()->stations->station_name,
            'receiver' => 'admin',
            'lreport_number' => $report_number,
            'content' => $submitDate . ' tarixi üçün ' . Auth::user()->stations->station_name . ' tərəfindən yerli ölçmələrin hesabatı sistemə daxil olundu.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . Auth::user()->stations->station_name .' üçün yerli ölçmələrin hesabatını sistemə daxil etdi.');

        $user = User::where('stations_id', $stations_id)
            ->where('position', 'Müdir')
            ->first();

        $user_name_surname = $user->name_surname;
        $user_email = 'chaparoglucavid@gmail.com';

        $reportData = [
            'title'             => 'Yerli ölçmələrin hesabatı',
            'content'           => Auth::user()->stations->station_name . ' üçün ' .  Carbon::now()->format('d.m.Y') . ' tarixinə olan hesabatı sistemə daxil edilib.',
            'localReport'       => $local,
            'user_name_surname' => $user_name_surname
        ];


        Mail::send('emails.localStore', ['reportData' => $reportData], function ($message) use ($user_email) {
            $message->to($user_email)->subject('Yerli ölçmələrin hesabatı');
        });

        return response()->json([
            'title' => 'Məlumatlar sistemə daxil edildi.',
            'message' => $submitDate . ' tarixi üçün məlumatlar sistemə daxil edildi.',
            'route' => route('local-broadcasts.index'),
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(LocalBroadcasts $localBroadcast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocalBroadcasts $localBroadcast)
    {
        $localBroadcast->load('frequencies.program_languages', 'frequencies.program_names', 'frequencies.directions', 'frequencies.polarizations');

        $frequencies = $localBroadcast->frequencies;
        $program_languages = $frequencies->program_languages;
        $program_names = $frequencies->program_names;
        $directions = $frequencies->directions;
        $polarizations = $frequencies->polarizations;

        $devices = config('data.devices');
        return view('local-broadcasts.edit', compact('localBroadcast', 'frequencies', 'program_languages', 'program_names', 'directions', 'devices', 'polarizations'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocalBroadcasts $localBroadcast)
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
        $localBroadcast->accepted_status = 0;
        $localBroadcast->update($data);
        $localBroadcast->save();

        $localBroadcast->edit_reasons->last()->update([
            'solved_status' => 1
        ]);

        Notifications::create([
            'sender' => Auth::user()->stations->station_name,
            'receiver' => 'admin',
            'lr_id' => $localBroadcast->id,
            'content' => $localBroadcast->report_date . ' tarixi üçün ' . Auth::user()->stations->station_name . ' tərəfindən daxil edilən yerli ölçmələrin hesabatı düzəliş edildikdən sonra təsdiq üçün göndərildi.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . Auth::user()->stations->station_name .' üçün verilən '. $localBroadcast->report_number .' nömrəli ölçmələrin hesabatında düzəliş etdi.');

        return response()->json([
            'message' => 'Məlumatlar yenilənib təsdiq üçün göndərildi.',
            'route' => route('local-broadcasts.index'),
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocalBroadcasts $localBroadcast)
    {
        //
    }
}
