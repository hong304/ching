<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use App\Models\Enquiry;
use App\Models\Recipe;
use App\Notifications\EnquiryNotification;
use App\Traits\CaptchaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StaticController extends Controller
{

    use CaptchaTrait;

    public function showCookies()
    {
        return view('front.home.cookies');
    }


    public function showPrivacyPolicy()
    {
        return view('front.home.privacy-policy');
    }


    public function showTermsAndConditions()
    {
        return view('front.home.terms-and-conditions');
    }


    public function showContact()
    {
        return view('front.home.contact');
    }

    public function showIndividual()
    {
        return view('front.recipe.individual');
    }

    public function showLotuswok()
    {
        return view('front.about.lotus-wok');
    }

    public function showBooks()
    {
        return view('front.about.books');
    }

    public function showAmazingAsia()
    {
        return view('front.about.amazing-asia');
    }

    public function showMyStory()
    {
        $recipe = Recipe::where('active',1)->orderBy('updated_at', 'desc')->first();
        $blog = Blog::where('published',1)->orderBy('id','desc')->first();
        return view('front.about.my-story', compact('recipe', 'blog'));
    }

    public function showBiography()
    {
        $recipe = Recipe::where('active',1)->orderBy('updated_at', 'desc')->first();
        $blog = Blog::where('published',1)->orderBy('id','desc')->first();
        return view('front.about.biography', compact('recipe', 'blog'));
    }

    public function postEnquiry(Request $request){

        if ($request->get('g-recaptcha-response')){
            $request['captcha'] = $this->captchaCheck($request->get('g-recaptcha-response'));
        }

        $validator = Validator::make($request->all(), [
            'first_name'=>'Required',
            'last_name'=>'Required',
            'email'=>'Required|Email',
            'message'=>'Required',
            'g-recaptcha-response' => 'required',
            'captcha' => 'required|in:1'
//            'register_agreement' =>'required'
        ],[
            'g-recaptcha-response.required' => 'Captcha is required',
            'captcha.in'           => 'Wrong captcha, please try again.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('from', 'contact');
        }

        $requiry = New Enquiry();
        $requiry->first_name = $request->first_name;
        $requiry->last_name = $request->last_name;
        $requiry->email = $request->email;
        $requiry->content = $request->message;
        $requiry->save();

        //send email here
        $requiry->notify(new EnquiryNotification($requiry));

        return redirect()->back()
            ->with('message', 'Thank you for your enquiry.')
            ->with('status', 'success')
            ->with('from','contactus');

      // Enquiry::insert($request->except('_token'));


    }

};