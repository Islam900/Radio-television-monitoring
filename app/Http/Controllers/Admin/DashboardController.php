<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logs()
    {
        $logs = Logs::orderBy('id', 'DESC')->get();
        return view('admin.logs', compact('logs'));
    }
}
