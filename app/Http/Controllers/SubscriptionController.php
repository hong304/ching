<?php

namespace App\Http\Controllers;


use App\Models\Subscription;
use App\Notifications\SubscriptionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{

    public function emailSubscription(Request $request)
    {

        $success_message = 'Thank you for your subscription.';

        $validator = Validator::make($request->all(), [
            'email'=>'Required|Between:3,64|Email|unique:users,email',
        ],[
            'email.unique' => $success_message,

        ]);

        if ($validator->fails()) {
            if($success_message == $validator->errors()->first('email')){
                //Email is already in user table
                return redirect()->route('index')
                    ->with('message_title', "Already a member!")
                    ->with('message', "Please login and change your subscription settings.")
                    ->with('status', 'success')
                    ->with('from','subscription');
            }else{ //email is not valid
                return redirect()->route('index')
                    ->with('message', $validator->errors()->first('email'))
                    ->with('status', 'fail')
                    ->with('from','subscription');
            }
        }

        if(Subscription::where('email',$request->email)->where('verified',1)->count()){
            //Email is already subscribed
            return redirect()->route('index')
                ->with('message_title', "Already subscribed!")
                ->with('message', 'Why not <a href="'. route('index').'#register' .'">sign up</a> free for full access?')
                ->with('status', 'success')
                ->with('from','subscription');
        }elseif ($subscription = Subscription::where('email',$request->email)->where('verified',0)->first()) {
            $subscription->notify(new SubscriptionNotification($subscription));
        }else{
            $subscription = new Subscription();
            $subscription->email = $request->input('email');
            $subscription->verify_code = uniqid();
            $subscription->verified = 0;
            $subscription->save();
            $subscription->notify(new SubscriptionNotification($subscription));
        }

        $request->session()->regenerateToken();
        
        return redirect()->route('index')
            ->with('message_title', "Thank you!")
            ->with('message', 'Thank you! Please check your email to verify your subscription.')
            ->with('status', 'success')
            ->with('from','subscription');
    }


    public function verifySubscription(Request $request)
    {

        $subscription = Subscription::where('verify_code', $request->verify_code)->where('email', $request->input('email'))->first();
        if($subscription){
            $subscription->verified = 1;
            $subscription->verify_code = '';
            $subscription->save();
            return redirect()->route('index')
                ->with('message', 'You have successfully verified your email.')
                ->with('status', 'success')
                ->with('from','subscription');
        }else{
            return redirect()->route('index')
                ->with('message', 'Verification fail.')
                ->with('status', 'fail')
                ->with('from','subscription');
        }


    }


    public function lotuswokSubscribe(Request $request)
    {
      $result = [];
      $result['message'] = 'Thank you for your subscription.';

      $validator = Validator::make($request->all(), [
        'email'=>'Required|Between:3,64|Email|unique:subscriptions,email',
      ],[
        'email.unique' => $result['message'],
      ]);

      if ($validator->fails()) {
        $result['status'] = false;
        $result['message'] = $validator->errors()->first('email');
      }

      if(Subscription::where('email',$request->email)->where('verified',1)->count()){
        //Email is already subscribed
        $result['status'] = false;
        $result['message'] = 'This email already subscribed.';
      }elseif ($subscription = Subscription::where('email',$request->email)->where('verified',0)->first()) {
        $subscription->notify(new SubscriptionNotification($subscription));

        $result['status'] = true;
        $result['message'] = 'Thank you! Please check your email to verify your subscription.';
      }else{
        $subscription = new Subscription();
        $subscription->email = $request->email;
        $subscription->lotus_wok = 1;
        $subscription->verify_code = uniqid();
        $subscription->verified = 0;
        $subscription->save();
        $subscription->notify(new SubscriptionNotification($subscription));

        $result['status'] = true;
        $result['message'] = 'Thank you! Please check your email to verify your subscription.';
      }

      $request->session()->regenerateToken();

      return response()->json($result);
    }
};