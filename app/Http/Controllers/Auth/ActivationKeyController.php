<?php

namespace App\Http\Controllers\Auth;

use App\Models\ActivationKey;
use App\Models\Country;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ActivationKeyTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use MaxMind\Db\Reader;

class ActivationKeyController extends Controller
{

    use ActivationKeyTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $validator = Validator::make($data,
            [
                'email'                 => 'required|email',
            ],
            [
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
            ]
        );

        return $validator;

    }

    public function showKeyResendForm(){

        return view('auth.resend_key');
    }

    public function activateKey($activation_key)
    {
        // determine if the user is logged-in already
        if (Auth::check() ) {
            if (Auth::user()->activated) {

                return redirect()->route('index')
                    ->with('message', 'Your email is already activated.')
                    ->with('status', 'success');
            }

        }

        // get the activation key and chck if its valid
        $activationKey = ActivationKey::where('activation_key', $activation_key)
            ->first();

        if (empty($activationKey)) {

            return redirect()->route('index')
                ->with('message', 'The provided activation key appears to be invalid')
                ->with('status', 'warning');

        }

        // process the activation key we're received
        $activation =  $this->processActivationKey($activationKey);
        if ($activation){
            // redirect to the login page after a successful activation
            return redirect()->route('index')
                ->with('message', 'You successfully activated your email! You are logged in.')
                ->with('status', 'success');
        }else{
            // redirect to the login page after a successful activation
            return redirect()->route('index')
                ->with('message', 'You have already activated your email! Please login.')
                ->with('status', 'success');
        }



    }

    public function resendKey(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $email      = $request->get('email');

        // get the user associated to this activation key
        $user = User::where('email', $email)
            ->first();

        if (empty($user)) {
            return redirect()->route('activation_key_resend')
                ->with('message', 'We could not find this email in our system')
                ->with('status', 'warning');
        }

        if ($user->activated) {
            return redirect()->route('index')
                ->with('message', 'You have activated your email account and can now login.')
                ->with('status', 'success');
        }

        // queue up another activation email for the user
        $this->queueActivationKeyNotification($user);

        return redirect()->route('index')
            ->with('message_title', 'Activation Email Resent')
            ->with('message', 'Please wait for up to 10 minutes for the message to arrive. Be sure to keep an eye on your spam folder as well!')
            ->with('status', 'success');
    }
}