<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\EditReasons;
use App\Models\LocalBroadcasts;
use App\Models\Logs;
use App\Models\Notifications;
use Egulias\EmailValidator\Result\Reason\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalBroadcastsController extends Controller
{
    public function update(Request $request)
    {
        EditReasons::create([
            'local_broadcasts_id'   => $request->report_id,
            'reason'                => $request->reason,
            'solved'                => 0
        ]);

        $report = LocalBroadcasts::find($request->report_id);
        $report->accepted_status = $request->accepted_status;
        $report->save();

        Notifications::create([
            'sender' => 'admin',
            'receiver' => $report->stations->station_name,
            'lr_id' => $report->id,
            'content' => $report->report_date.' tarixi üçün '.$report->stations->station_name.' tərəfindən göndərilən yerli ölçmələrin hesabatı düzəliş üçün geri göndərildi.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $report->report_date.' tarixi üçün '.$report->stations->station_name.' tərəfindən göndərilən yerli ölçmələrin hesabatını düzəliş üçün geri göndərdi.');

        return response()->json([
            'message' => 'Gündəlik hesabat düzəliş üçün məntəqəyə göndərildi',
            'route' => route('stations.show', $report->stations->id),
            'status'  => 200
        ]);
    }

    public function update_confirm(Request $request)
    {
        $report = LocalBroadcasts::find($request->report_id);
        $report->accepted_status = $request->accepted_status;
        $report->save();

        Notifications::create([
            'sender' => 'admin',
            'receiver' => $report->stations->station_name,
            'lr_id' => $report->id,
            'content' => $report->report_date.' tarixi üçün '.$report->stations->station_name.' tərəfindən göndərilən yerli ölçmələrin hesabatı təsdiq edildi.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        (new LogsController())->create_logs(  Auth::user()->name_surname. ' ' . $report->report_date.' tarixi üçün '.$report->stations->station_name.' tərəfindən göndərilən yerli ölçmələrin hesabatını təsdiq etdi.');

        return response()->json([
            'message' => 'Gündəlik hesabat təsdiqləndi',
            'status'  => 200
        ]);
    }
}
