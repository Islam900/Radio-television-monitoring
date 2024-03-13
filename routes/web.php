<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::fallback(function () {
    return view('404');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('post-login');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'is_admin:user'])->group(function (){
//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('station-profile', [\App\Http\Controllers\HomeController::class, 'station_profile'])->name('station-profile');
    Route::put('update-station-profile/{id}', [\App\Http\Controllers\HomeController::class, 'update_station_profile'])->name('update-station-profile');
    Route::resource('/local-broadcasts', \App\Http\Controllers\LocalBroadcastController::class);
    Route::resource('/foreign-broadcasts', \App\Http\Controllers\ForeignBroadcastController::class);

    Route::post('get-data-by-frequency', [\App\Http\Controllers\HomeController::class, 'get_data_by_frequency'])->name('get-data-by-frequency');
});


Route::middleware(['auth', 'is_admin:admin'])->group(function (){
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('all-stations', [\App\Http\Controllers\Admin\StationsController::class, 'all_stations'])->name('stations.all-stations');
    Route::get('stations/{id}/show', [\App\Http\Controllers\Admin\StationsController::class, 'show'])->name('stations.show');
    Route::get('stations/{id}/edit', [\App\Http\Controllers\Admin\StationsController::class, 'edit'])->name('stations.edit');

    Route::post('dashboard-local-broadcasts/send-to-update', [\App\Http\Controllers\Admin\LocalBroadcastsController::class, 'update'])->name('dashboard-local-broadcasts.send-to-update');
    Route::post('dashboard-local-broadcasts/confirm', [\App\Http\Controllers\Admin\LocalBroadcastsController::class, 'update_confirm'])->name('dashboard-local-broadcasts.confirm');

    Route::post('dashboard-foreign-broadcasts/send-to-update', [\App\Http\Controllers\Admin\ForeignBroadcastsController::class, 'update'])->name('dashboard-foreign-broadcasts.send-to-update');
    Route::post('dashboard-foreign-broadcasts/confirm', [\App\Http\Controllers\Admin\ForeignBroadcastsController::class, 'update_confirm'])->name('dashboard-foreign-broadcasts.confirm');

    Route::resource('frequencies', \App\Http\Controllers\Admin\FrequenciesController::class);
    Route::resource('directions', \App\Http\Controllers\Admin\DirectionsController::class);
    Route::resource('program-locations', \App\Http\Controllers\Admin\ProgramLocationsController::class);
    Route::resource('program-languages', \App\Http\Controllers\Admin\ProgramLanguagesController::class);
    Route::resource('program-names', \App\Http\Controllers\Admin\ProgramNamesController::class);

    Route::resource('system-users', \App\Http\Controllers\Admin\SystemUsersController::class);
    Route::post('system-users/ban-user', [\App\Http\Controllers\Admin\SystemUsersController::class, 'ban_user'])->name('system-users.ban-user');
    Route::post('system-users/unban-user', [\App\Http\Controllers\Admin\SystemUsersController::class, 'unban_user'])->name('system-users.unban-user');

    Route::resource('stations-users', \App\Http\Controllers\Admin\StationsUsersController::class);

    Route::get('logs', [\App\Http\Controllers\Admin\DashboardController::class, 'logs'])->name('logs');

    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class);
});
