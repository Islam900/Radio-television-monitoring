<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramNames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProgramNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $program_names = ProgramNames::all();
        return view('admin.informations.program-names.index', compact('program_names'));
    }

    public function create()
    {
        return view('admin.informations.program-names.create');
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

        ProgramNames::create($request->all());

        return redirect()->route('program-names.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə əlavə edildi');
    }

    public function show(ProgramNames $program_name)
    {
        return view('admin.informations.program-names.show', compact('program_name'));
    }

    public function edit(ProgramNames $program_name)
    {
        return view('admin.informations.program-names.edit', compact('program_name'));
    }

    public function update(Request $request, ProgramNames $program_name)
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

        $program_name->update($request->all());

        return redirect()->route('program-names.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə yeniləndi');
    }

    public function destroy(ProgramNames $program_name)
    {
        $program_name->delete();

        return redirect()->route('program-names.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə silindi');
    }
}
