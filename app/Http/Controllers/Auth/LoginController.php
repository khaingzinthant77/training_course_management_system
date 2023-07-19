<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PasswordResetLinkRequest;
use App\Http\Requests\ResetPasswordReqeust;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function ajax_normal_login()
    {
        $loginColumn = 'phone';
        $password = $_POST['password'] ?? '';


        // if email login
        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $loginColumn = 'email';
        }
        $data = [
            $loginColumn => $_POST['email'],
            'password' => $password,
        ];

        // Normal Force Login
        if (!Auth::attempt($data)) {
            return [
                'status' => 0,
                'message' => 'Sorry, Invalid Credentials!',
            ];
        } else {
            // LOGIN SUCCESS
            return [
                'status' => 1,
                'message' => 'Login Success',
                'type' =>  'direct',
                'redirect_to' => route('home')
            ];
        }
    }

    // Ajax Login
    public function ajax_login()
    {
        $loginColumn = 'phone';
        $password = $_GET['password'] ?? '';


        // if email login
        if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $loginColumn = 'email';
        } else {
            $loginColumn = "name";
        }
        $data = [
            $loginColumn => $_GET['email'],
            'password' => $password,
        ];


        // Normal Force Login
        if (!Auth::attempt($data)) {
            return [
                'status' => 0,
                'message' => 'Sorry, Invalid Credentials!',
            ];
        } else {
            // LOGIN SUCCESS
            return [
                'status' => 1,
                'message' => 'Login Success',
                'type' =>  'direct',
                'redirect_to' => route('home')
            ];
        }
    }

    // forgot password
    public function forgot_password()
    {
        return view('auth.forgotpassword');
    }

    // forgot_password_reseted
    public function forgot_password_reseted()
    {
        return view('auth.forgot_password_reseted');
    }

    // password_reset 
    public function password_reset()
    {
        return view('auth.password_reset_form');
    }

    // send_reset_link 
    public function send_reset_link(PasswordResetLinkRequest  $request)
    {

        $user = User::select('role_id', 'id', 'email', 'name')->where('email', $request->email)->first();

        // User Doesn't Exist
        if (!$user) {
            return redirect()->back()->withErrors(['no_user' => 'There is no user with that email address']);
        }

        // Mail Configuration
        setMailConfig();

        $link = url('/') . '/password_reset?id=' . $user->id;

        $details = [
            'name' => $user->name,
            'email' => $user->email,
            'link' => $link
        ];

        //  If Super Admin
        if ($user->role_id == 'Super Admin') {

            $recovery_mail = Setting::first()->recovery_mail;

            if (is_null($recovery_mail)) {
                return redirect()->back()->withErrors(['no_rm' => 'There is no recovery mail address']);
            }

            $user->update([
                'pwd_reset_timestamp' => Carbon::now()
            ]);
            Mail::to($recovery_mail)->send(new \App\Mail\PasswordResetLinkEmail($details));
        } else {
            $user->update([
                'pwd_reset_timestamp' => Carbon::now()
            ]);
            Mail::to($user->email)->send(new \App\Mail\PasswordResetLinkEmail($details));
        }

        return view('auth.forgot_password_reseted');
    }

    // reset_password 
    public function pwd_reset(ResetPasswordReqeust $request)
    {
        $user = User::find($request->user_id);

        if (is_null($user)) {
            return redirect()->back()->withErrors(['user' => 'Something went wrong!']);
        }

        // create a new Carbon instance for the incoming timestamp
        $resetTimeStamp = Carbon::createFromTimestamp(strtotime($user->pwd_reset_timestamp));

        $pwd_expire_time = Setting::first()->pwd_reset_expire;

        // create a new Carbon instance for the current time
        $currentTime = Carbon::now();

        if ($resetTimeStamp->addMinutes($pwd_expire_time)->lt($currentTime)) {
            return redirect()->back()->withErrors(['expire' => 'Reset Link Expired.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Password Reseted!');
    }
}