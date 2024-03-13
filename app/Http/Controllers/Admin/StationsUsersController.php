<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\Logs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stations;

class StationsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('type', 'user')->get();
        return view('admin.users.station-users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stations = Stations::all();
        return view('admin.users.station-users.create', compact('stations'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name_surname' => $request->name_surname,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt($request->password),
            'contact_number' => $request->contact_number,
            'type' => 'user',
            'position' => $request->position,
            'activity_status' => 1
        ]);
        
        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $user->name_surname . ' adlı məntəqə istifadəçisi yaratdı.');

        return redirect()->route('station-users.index')->with('store_success', 'Məlumatlar daxil edildi');
    }
    public function ban_user(Request $request)
    {
        $user = User::find($request->user_id);
        $user->activity_status = 0;
        $user->ban_start_date = Carbon::now()->format('Y-m-d');
        $user->ban_end_date = $request->ban_end_date;
        $user->save();

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $user->name_surname . ' adlı sistem istifadəçisinin girişini məhdudlaşdırdı.');

        return response()->json([
            'message' => 'İstifadəçisinin sistemə girişi '. $request->ban_end_date .' tarixinədək məhdudlaşdırıldı.',
            'route' => route('station-users.index'),
            'status' => 200
        ]);
    }

    public function unban_user(Request $request)
    {
        $user = User::find($request->user_id);
        $user->activity_status = 1;
        $user->ban_start_date = NULL;
        $user->ban_end_date = NULL;
        $user->save();

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $user->name_surname . ' adlı sistem istifadəçisinin məhdudiyyətini aradan qaldırdı.');

        return response()->json([
            'message' => 'İstifadəçisinin sistemə girişi bərpa edildi',
            'route' => route('station-users.index'),
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $stations = Stations::all();
        return view('admin.users.station-users.edit', compact('user', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->fill([
            'name_surname' => $request->name_surname,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'position' => $request->position,
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $user->name_surname . ' adlı sistem istifadəçisinin məlumatlarını dəyişdirdi.');

        return redirect()->route('station-users.index')->with('update_success', 'Məlumatlar müvəffəqiyyətlə dəyişdirildi');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::find($id);

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $user->name_surname . ' adlı sistem istifadəçisi sistemdən sildi.');


    }
}
