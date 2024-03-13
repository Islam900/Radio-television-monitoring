<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
use App\Models\Logs;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->activity_status == 1) {

                (new LogsController())->create_logs($user->name_surname . ' sistemə giriş etdi.');

                if ($user->type == 'user') {
                    if ($user->stations->status == 0) {
                        Auth::logout();
                        return redirect()->back()->with('login_error', 'Məntəqənin sistemə girişi mərkəz tərəfindən məhdudlaşdırılıb.');
                    }
                    return redirect()->route('local-broadcasts.index')->with('login_success', 'Sistemə daxil oldunuz');
                } elseif ($user->type == 'admin') {
                    return redirect()->route('dashboard')->with('login_success', 'Sistemə daxil oldunuz');
                }
            } else {

                Auth::logout();
                return redirect()->back()->with('login_error', 'Sistemə girişiniz mərkəz tərəfindən ' . $user->ban_start_date . ' tarixdən ' . $user->ban_end_date . ' tarixədək məhdudlaşdırılıb.');
            }
        }
        return redirect()->back()->withInput(request()->only('email'))->with('login_error', 'Daxil etdiyiniz məlumatlar doğru deyil');

    }
    public function logout(Request $request)
    {

        (new LogsController())->create_logs(Auth::user()->name_surname . ' sistemdən çıxış etdi.');
        Auth::logout();
        return redirect('/');
    }
}
