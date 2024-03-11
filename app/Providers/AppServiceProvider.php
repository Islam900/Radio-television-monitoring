<?php

namespace App\Providers;

use App\Models\ForeignBroadcasts;
use App\Models\LocalBroadcasts;
use App\Models\Notifications;
use App\Models\Stations;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('*', function ($view) {
            if (Auth::check()) {
                if (Auth::user()->type == 'admin') {
                    $stations = Stations::all();
                    $notifications = Notifications::all();
                    $unread_notifications_count = $notifications->where('r_read', 0)->count();
                    $view->with(['stations' => $stations, 'notifications' => $notifications, 'unread_notifications_count' => $unread_notifications_count]);
                } elseif (Auth::user()->type == 'user') {
                    $userStations = Auth::user()->stations;
                    $frequenciesCount = $userStations->frequencies->count();
                    $submitDate = Carbon::now()->format('Y-m-d');

                    $existingLocalBroadcastsCount = $userStations->local_broadcasts()->whereDate('report_date', $submitDate)->count();
                    $newLocalBroadcastButtonStatus = $existingLocalBroadcastsCount < $frequenciesCount;

                    $existingForeignBroadcastsCount = $userStations->foreign_broadcasts()->whereDate('report_date', $submitDate)->count();
                    $newForeignBroadcastButtonStatus = $existingForeignBroadcastsCount < $frequenciesCount;

                    $notifications = Notifications::where('sender', $userStations->station_name)
                        ->orWhere('receiver', $userStations->station_name)
                        ->get();

                    $unread_notifications_count = $notifications->where('r_read', 0)->count();
                    $view->with([
                        'notifications' => $notifications,
                        'unread_notifications_count' => $unread_notifications_count,
                        'local_broadcast_button_status' => $newLocalBroadcastButtonStatus,
                        'foreign_broadcast_button_status' => $newForeignBroadcastButtonStatus
                    ]);
                }
            }

        });
    }
}
