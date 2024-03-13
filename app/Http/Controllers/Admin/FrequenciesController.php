<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\Directions;
use App\Models\Frequencies;
use App\Models\FrequenciesStations;
use App\Models\Logs;
use App\Models\Polarizations;
use App\Models\ProgramLanguages;
use App\Models\ProgramLocations;
use App\Models\ProgramNames;
use App\Models\Stations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrequenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frequencies = Frequencies::all();
        return view('admin.informations.frequencies.index', compact('frequencies'));
    }

    public function create()
    {
        $program_languages = ProgramLanguages::all();
        $directions = Directions::all();
        $program_names = ProgramNames::all();
        $polarizations = Polarizations::all();
        $program_locations = ProgramLocations::all();
        $stations = Stations::all();
        return view('admin.informations.frequencies.create', compact('program_languages','program_names', 'program_locations', 'directions', 'polarizations','stations'));
    }

    public function store(Request $request)
    {
        $frequency = Frequencies::create($request->all());

        FrequenciesStations::create([
            'stations_id' => $request->stations_id,
            'frequencies_id' => $frequency->id
        ]);

        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $request->value .'  tezliyini sistemə daxil etdi');

        return redirect()->route('frequencies.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə əlavə edildi');
    }

    public function show(Frequencies $frequency)
    {
        return view('admin.informations.frequencies.show', compact('frequency'));
    }

    public function edit(Frequencies $frequency)
    {
        return view('admin.informations.frequencies.edit', compact('frequency'));
    }

    public function update(Request $request, Frequencies $frequency)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Session::flash('errors', $errors);
            return redirect()->back();
        }

        $frequency->update($request->all());

        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $frequency->value .'  tezlik məlumatlarını dəyişdirdi');

        return redirect()->route('frequencies.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə yeniləndi');
    }

    public function destroy(Frequencies $frequency)
    {
        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $frequency->value .' tezlik məlumatlarını sistemdən sildi');

        $frequency->delete();

        return redirect()->route('frequencies.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə silindi');
    }
}
