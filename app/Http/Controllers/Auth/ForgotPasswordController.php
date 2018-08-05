<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Exception;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    protected function sendResetLinkResponse($response)
    {
        return back()->with('status','success')->with('from','forgotpassword')->with('message',trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request,$response)
    {
        return Redirect::to(URL::previous() . "#forgotpassword")->with('status','fail')->with('from','forgotpassword')->with('message',trans($response));

    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            $this->validate($request, ['email' => 'required|email']);
        } catch (Exception $e) {
            return Redirect::to(URL::previous() . "#forgotpassword")->with('status','fail')->with('from','forgotpassword')->with('message','Oops! It seems like there’s an unexpected problem we cannot process at this time.');
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

}
