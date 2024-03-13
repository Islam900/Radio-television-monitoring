<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function create_logs($content)
    {
        Logs::create([
            'ip_address' => NULL,
            'mac_address' => NULL,
            'type' => 'Bildiriş',
            'content' => $content
        ]);
    }
}
