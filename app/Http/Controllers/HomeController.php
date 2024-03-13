<?php

namespace App\Http\Controllers;

use App\Models\Frequencies;
use App\Models\LocalBroadcasts;
use App\Models\Logs;
use App\Models\Stations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $emfs_level = Auth::user()->stations->local_broadcasts()->whereBetween('report_date', [now()->subDays(30), now()])->pluck('emfs_level')->toArray();
        return view('home', compact('emfs_level'));
    }

    public function station_profile()
    {
        $coordinate_N = Auth::user()->stations->coordinate_N;
        $coordinate_E = Auth::user()->stations->coordinate_E;

        $n = preg_split("/°|\"|'/", $coordinate_N, -1, PREG_SPLIT_NO_EMPTY);
        $e = preg_split("/°|\"|'/", $coordinate_E, -1, PREG_SPLIT_NO_EMPTY);



        return view('settings.profile', compact('n', 'e'));
    }

    public function update_station_profile(Request $request, $id)
    {
        (new LogsController())->create_logs(Auth::user()->name_surname. ' hesab məlumatlarında düzəliş etdi.');

        $validator = Validator::make($request->all(), [
            'name_surname' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            Session::flash('errors', $errors);
            return redirect()->back();
        }

        $data = $request->all();

        $user = User::find($id);
        if($request->password)
        {
            if(bcrypt($request->new_password) == Auth::user()->password)
            {
                return redirect()->route('station-profile')
                    ->with('error', 'Daxil etdiyiniz yeni şifrə mövcud şifrə ilə eynidir!');
            }
        elseif(bcrypt($request->password) != Auth::user()->password)
            {
                return redirect()->route('station-profile')
                    ->with('error', 'Mövcud şifrəni düzgün daxil etməmisiniz!');
            }
        else {
                $data['password'] = bcrypt($request->new_password);
            }
            $user->password = $data['password'];
        }

        $user->name_surname = $request->name_surname;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->save();

        return redirect()->route('station-profile')
            ->with('success', 'Məlumatlar müvəffəqiyyətlə dəyişdirildi.');
    }

    public function get_data_by_frequency(Request $request)
    {
        $frequency = Auth::user()->stations()->first()->frequencies()->where('value', $request->frequencies_id)->first();
        $frequency_data = $frequency->load('program_names', 'program_languages', 'directions', 'polarizations', 'program_locations');
        return $frequency_data;
    }

}
