<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\Frequencies;
use App\Models\Logs;
use App\Models\ProgramLanguages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProgramLanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $program_languages = ProgramLanguages::all();
        return view('admin.informations.program-languages.index', compact('program_languages'));
    }

    public function create()
    {
        return view('admin.informations.program-languages.create');
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

        ProgramLanguages::create($request->all());

        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $request->name .' adlı proqram dilini sistemə daxil etdi');
        return redirect()->route('program-languages.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə əlavə edildi');
    }

    public function show(ProgramLanguages $program_language)
    {
        return view('admin.informations.program-languages.show', compact('program_language'));
    }

    public function edit(ProgramLanguages $program_language)
    {
        return view('admin.informations.program-languages.edit', compact('program_language'));
    }

    public function update(Request $request, ProgramLanguages $program_language)
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

        $program_language->update($request->all());

        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $request->name .' adlı proqram dili məlumatlarını dəyişdirdi');

        return redirect()->route('program-languages.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə yeniləndi');
    }

    public function destroy(ProgramLanguages $program_language)
    {
        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $program_language->name .' adlı proqramın yayımlandığı dil məlumatlarını sistemdən sildi');

        $program_language->delete();

        return redirect()->route('program-languages.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə silindi');
    }
}
