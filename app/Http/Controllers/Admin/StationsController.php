<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForeignBroadcasts;
use App\Models\LocalBroadcasts;
use App\Models\Stations;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $station = Stations::find($id);
            $reports = $station->local_broadcasts()->get();
            $freports = $station->foreign_broadcasts()->get();
            return view('admin.stations.show', compact('reports','freports', 'station'));
    }

    public function all_stations()
    {
        $stations = Stations::all();
        return view('admin.stations.all-stations', compact('stations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $station = Stations::with('user')->withCount('local_broadcasts', 'foreign_broadcasts')->find($id);
        return view('station');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
