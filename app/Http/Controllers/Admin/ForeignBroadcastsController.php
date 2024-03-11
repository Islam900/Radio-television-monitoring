<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EditReasons;
use App\Models\ForeignBroadcasts;
use App\Models\Notifications;
use Illuminate\Http\Request;

class ForeignBroadcastsController extends Controller
{
    public function update(Request $request)
    {
        EditReasons::create([
            'foreign_broadcasts_id'   => $request->report_id,
            'reason'                => $request->reason,
            'solved'                => 0
        ]);

        $report = ForeignBroadcasts::find($request->report_id);
        $report->accepted_status = $request->accepted_status;
        $report->save();

        Notifications::create([
            'sender' => 'admin',
            'receiver' => $report->stations->station_name,
            'lr_id' => $report->id,
            'content' => $report->report_date.' tarixi üçün '.$report->stations->station_name.' tərəfindən göndərilən kənar ölçmələrin hesabatı düzəliş üçün geri göndərildi.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        return response()->json([
            'message' => 'Gündəlik hesabat düzəliş üçün məntəqəyə göndərildi',
            'status'  => 200
        ]);
    }

    public function update_confirm(Request $request)
    {
        $report = ForeignBroadcasts::find($request->report_id);
        $report->accepted_status = $request->accepted_status;
        $report->save();

        Notifications::create([
            'sender' => 'admin',
            'receiver' => $report->stations->station_name,
            'lr_id' => $report->id,
            'content' => $report->report_date.' tarixi üçün '.$report->stations->station_name.' tərəfindən göndərilən kənar ölçmələrin hesabatı təsdiq edildi.',
            's_read' => 0,
            'r_read' => 0,
        ]);

        return response()->json([
            'message' => 'Gündəlik hesabat təsdiqləndi',
            'status'  => 200
        ]);
    }
}
