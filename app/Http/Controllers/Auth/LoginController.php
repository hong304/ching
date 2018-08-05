<?php

namespace App\Http\Controllers\Auth;

use App\Models\AuditLogin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActivationKeyTrait;
use Socialite;
use Exception;
use Session;

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

    use AuthenticatesUsers, ActivationKeyTrait;

    /**
     * Auth guard
     *
     * @var
     */
    protected $auth;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth, Request $request)
    {
        $this->middleware('guest', ['except' => 'logout']);

        if ($request->redirect != '')
            $this->redirectTo = $request->redirect;

        $this->auth = $auth;
    }

    public function showLoginForm()
    {
        $redirectUrl = URL::previous();
        if (substr($redirectUrl, 0, strlen(env('APP_URL')) === env('APP_URL'))) {
            $redirectUrl = "/";
        }
        Session::put('url.intended', $redirectUrl);
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('remember');

        // dd(md5('123456'));

        $user = User::where('email', $request->email)->first();
        if (count($user)) {
            if (isset($user->password_old) && $user->password_old == md5($request->password))
                $user->password = bcrypt($request->password);
            $user->password_old = '';
            $user->save();
        }

        if ($this->auth->attempt([
            'email' => $username,
            'password' => $password
        ], $remember == 1 ? true : false)) {

            //$this->saveAuditLogin();


            if (Auth::user()->activated) {
                //return redirect()->route('index');
                $url = Session::get('url.intended', url('/'));
                Session::forget('url.intended');
                return redirect($url);
                //return redirect($this->redirectTo);
            } else {
                Auth::logout();
                return redirect()->route('activation_key_resend');
            }

        } else {
            return redirect()->route('login')
                ->withErrors('Incorrect username or password')
                ->with('from', 'login')
                ->withInput();
        }

    }

    private function saveAuditLogin()
    {
        static::recordAuditLogin($this->redirectTo);
    }

    public static function recordAuditLogin($redirect = '/')
    {
        $user = Auth::user();
        $user->last_login_time = Carbon::now();
        $user->save();
        Cookie::queue('closeCookie', true, 0);

        if (Session::has('geoData')) {

            $login_history = Session::get('geoData');


            // make login history table and add
            // user_id, $login_history['ipaddress'], and $login_history['country_data']['continent']['names']['en'] and $login_history['country_data']['country']['names']['en']
            // model needs user_id, ipaddress, continent, country, datetime stamps auth

            $loginHistories = new AuditLogin();
            $loginHistories->user_id = Auth::user()->id;
            $loginHistories->ip_address = $login_history['ipaddress'];


            if (isset($login_history['country_data']['continent']['names']['en'])) {
                $loginHistories->continent = $login_history['country_data']['continent']['names']['en'];
            }

            if (isset($login_history['country_data']['country']['names']['en'])) {
                $loginHistories->country = $login_history['country_data']['country']['names']['en'];
            }

            $url = Session::get('url.intended', $redirect);
            $from_page = str_replace(config('app.url') . '/', "", $url);
            $loginHistories->from = $from_page;
            $loginHistories->save();

        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function redirectToFacebook()
    {

//        Session::put('url.intended', URL::previous());
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            //get facebook callback data
            $user = Socialite::driver('facebook')->fields([
                'first_name', 'last_name', 'email', 'gender'
            ])->scopes([
                'email', 'user_birthday'
            ])->user();

            //find user in db
            $authUser = User::where('facebook_id', $user->id)->first();
            if ($authUser && $authUser->activated) { //valid user is found and log user in

                Auth::login($authUser, true);

                $this->saveAuditLogin();
                $url = Session::get('url.intended', url('/'));
                Session::forget('url.intended');
                return redirect($url);

            } elseif ($authUser && $authUser->email && !$authUser->activated) { //if facebook user is not activated his email
                return redirect()->route('activation_key_resend');
            } elseif ($user->email && User::where('email', $user->email)->count() > 0) { //if user email is found, update user info and login

                $update = User::where('email', $user->email)->first();
                $update->facebook_id = $user->id;
                $update->first_name = ($update->first_name) ? $update->first_name : $user->user['first_name'];
                $update->last_name = ($update->last_name) ? $update->last_name : $user->user['last_name'];
                $update->nick_name = ($update->nick_name) ? $update->nick_name : $user->nickname;
                if (!$update->activated) {
                    $update->activated = "1";
                    $update->activation_time = Carbon::now();
                }

                $update->save();

                Auth::login($update, true);
                $this->saveAuditLogin();

                $url = Session::get('url.intended', url('/'));
                Session::forget('url.intended');
                return redirect($url);

            } else {  //user not found in db, try to create user

                $create['first_name'] = $user->user['first_name'];
                $create['last_name'] = $user->user['last_name'];
                $create['nick_name'] = $user->nickname;
                $create['facebook_id'] = $user->id;
                $create['gender'] = $user->user['gender'];
                $create['activated'] = "1";

                if ($user->email) { //if there is email in callback

                    $create['email'] = $user->email;
                    $create->activation_time = Carbon::now();
                    $newUser = User::create($create);

                    Auth::login($newUser, true);
                    $this->saveAuditLogin();
                    $url = Session::get('url.intended', url('/'));
                    Session::forget('url.intended');
                    return redirect($url);

                } else { //if no email address in callback, ask user to add it
                    $create['activated'] = "0";
                    session(['not_auth_user' => $create]);
                    //-----> redirect to add email page
                    return redirect()->route('complete_facebook_sign_up');
                }

            }
        } catch (Exception $e) {
            return redirect()->route('index', "#register");
        }
    }

    public function completeFacebookSignUp(Request $request)
    {
        if (!session()->exists('not_auth_user')) {
            return redirect()->route('index', "#register");
        }

        $validator = Validator::make($request->all(), [
            'email' => 'Required|Between:3,64|Email|unique:users',
            'confirmed_email' => 'required|same:email',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('status', 'fail')
                ->with('from', 'complete-facebook');
        } else {
            $create = session('not_auth_user');
            $create['activated'] = 0;
            $create['email'] = $request->email;

            $newUser = User::create($create);

            $this->queueActivationKeyNotification($newUser);

            session()->forget('not_auth_user');
            return redirect()->route('index')
                ->with('message', "We sent you an activation code. Please check your email.")
                ->with('status', 'success');
        }
    }

    public function showCompleteFacebookSignUp()
    {
        if (!session()->exists('not_auth_user')) {
            return redirect()->route('index', "#register");
        }

        return view('auth.complete-facebook-signup');
    }
}
