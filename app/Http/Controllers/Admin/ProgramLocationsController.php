<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frequencies;
use App\Models\ProgramLanguages;
use App\Models\ProgramLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProgramLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $program_locations = ProgramLocations::all();
        return view('admin.informations.program-locations.index', compact('program_locations'));
    }

    public function create()
    {
        return view('admin.informations.program-locations.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Session::flash('errors', $errors);
            return redirect()->back();
        }

        ProgramLocations::create($request->all());

        return redirect()->route('program-locations.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə əlavə edildi');
    }

    public function show(ProgramLocations $program_location)
    {
        return view('admin.informations.program-locations.show', compact('program_location'));
    }

    public function edit(ProgramLocations $program_location)
    {
        return view('admin.informations.program-locations.edit', compact('program_location'));
    }

    public function update(Request $request, ProgramLocations $program_location)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Session::flash('errors', $errors);
            return redirect()->back();
        }

        $program_location->update($request->all());

        return redirect()->route('program-locations.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə yeniləndi');
    }

    public function destroy(ProgramLocations $program_location)
    {
        $program_location->delete();

        return redirect()->route('program-locations.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə silindi');
    }
}
