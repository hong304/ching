<?php

namespace App\Http\Controllers\Auth;


use App\Models\Country;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Traits\CaptchaTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\ActivationKeyTrait;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, ActivationKeyTrait,CaptchaTrait;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        if (isset($data['g-recaptcha-response'])){
            $data['captcha'] = $this->captchaCheck($data['g-recaptcha-response']);
        }
        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender'=> 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password',
            'g-recaptcha-response'  => 'required',
            'captcha'               => 'required|in:1'
//            'register_agreement' =>'required'
        ],[
            'g-recaptcha-response.required' => 'Captcha is required',
            'captcha.in'           => 'Wrong captcha, please try again.'
        ]);

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender'=>$data['gender'],
            'tel_mobile'=>$data['tel_mobile'],
            'country_code'=>$data['country_code'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'activated' => !config('settings.send_activation_email')
        ]);
    }

    public function register(Request $request)
    {

        $validator = $this->validator($request->all());


        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('from', 'register');
        }


        // create the user
        $user = $this->create($request->all());


        // process the activation email for the user
        $this->queueActivationKeyNotification($user);

        Cookie::queue('closeCookie', true, 0);

        // we do not want to login the new user
        return redirect()->route('index')
            ->with('message', 'Thanks for signing up! Please check your email inbox to activate your account. It can take up to 10 minutes for the message to arrive.<br> If you don\'t receive it within this time, be sure to check your spam folders or login again to request a new activation email.')
            ->with('from', 'register')
            ->with('status', 'success');
    }

    public function showRegistrationForm()
    {
        $data['countries'] = Country::getCountriesListWithFlag();
        return view('auth.register', $data);
    }
}
