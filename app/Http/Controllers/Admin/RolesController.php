<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->role,
            'guard_name' => 'web'
        ]);

        $permissions = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $request->role .' adlı vəzifəni sistemə daxil etdi');

        return redirect()->route('roles.index');
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
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $request->role .' adlı vəzifə məlumatlarında düzəliş etdi');

        $role = Role::find($id);
        $role->name = $request->role;
        $role->save();

        $permissions = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
        $role->syncPermissions($permissions);



        return redirect()->route('roles.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $role = Role::find($id);

        (new LogsController())->create_logs(Auth::user()->name_surname. ' ' . $role->name .' adlı proqram dilini sistemdən sildi');

        $role->revokePermissionTo($role->permissions);
        $role->users()->detach();
        $role->delete();

        return response()->json([
            'message' => 'Məlumatlar müvəffəqiyyətlə silindi',
            'route' => route('roles.index'),
            'status' => 200
        ]);
    }
}
