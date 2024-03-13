<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\Directions;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DirectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = Directions::all();
        return view('admin.informations.directions.index', compact('directions'));
    }

    public function create()
    {
        return view('admin.informations.directions.create');
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

        Directions::create($request->all());

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $request->name .' adlı istiqaməti sistemə daxil etdi');

        return redirect()->route('Directions.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə əlavə edildi');
    }

    public function show(Directions $direction)
    {
        return view('admin.informations.directions.show', compact('direction'));
    }

    public function edit(Directions $direction)
    {
        return view('admin.informations.directions.edit', compact('direction'));
    }

    public function update(Request $request, Directions $direction)
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

        $direction->update($request->all());

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $request->name .' adlı istiqamət məlumatlarını dəyişdirdi');


        return redirect()->route('directions.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə yeniləndi');
    }

    public function destroy(Directions $direction)
    {
        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $direction->name .' adlı istiqamət məlumatlarını sistemdən sildi');

        $direction->delete();

        return redirect()->route('directions.index')
            ->with('store_success', 'Məlumatlar müvəffəqiyyətlə silindi');
    }
}
