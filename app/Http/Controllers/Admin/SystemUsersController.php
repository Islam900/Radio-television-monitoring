<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SystemUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('type', 'admin')->get();
        return view('admin.users.system-users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.system-users.create', compact('roles'));

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
            'type' => 'admin',
            'position' => Role::find($request->role)->name,
            'activity_status' => 1
        ]);
        $role = Role::find($request->role);
        $user->assignRole($role);
        return redirect()->route('system-users.index')->with('store_success', 'Məlumatlar daxil edildi');
    }
    public function ban_user(Request $request)
    {
        $user = User::find($request->user_id);
        $user->activity_status = 0;
        $user->ban_start_date = Carbon::now()->format('Y-m-d');
        $user->ban_end_date = $request->ban_end_date;
        $user->save();

        return response()->json([
            'message' => 'İstifadəçisinin sistemə girişi '. $request->ban_end_date .' tarixinədək məhdudlaşdırıldı.',
            'route' => route('system-users.index'),
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

        return response()->json([
            'message' => 'İstifadəçisinin sistemə girişi bərpa edildi',
            'route' => route('system-users.index'),
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
        $roles = Role::all();
        return view('admin.users.system-users.edit', compact('user', 'roles'));
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
        ]);

        $roleId = $request->role;
        $role = Role::find($roleId);

        if ($role) {
            $user->position = $role->name;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        if ($role) {
            $user->syncRoles($role);
        }

        return redirect()->route('system-users.index')->with('update_success', 'Məlumatlar müvəffəqiyyətlə dəyişdirildi');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::find($id);
        $user->permissions()->detach();
        $user->roles()->detach();
        $user->delete();

    }
}
