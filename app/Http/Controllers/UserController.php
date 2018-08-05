<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Traits\ActivationKeyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Images;
use Validator;
use Cache;

class UserController extends Controller
{

    use ActivationKeyTrait;

    public function showIndex()
    {
        return view('front.user.profile');
    }

    public function getUserData(Request $request){

        // get the countries list from db
        if (Cache::has('countries_for_view'))
        {
            $countries = Cache::get('countries_for_view');
        }
        else
        {
            $countries = Country::getCountriesListWithFlag();
            // put in cache for 2 hours
            Cache::put('countries_for_view', $countries, 120);
        }

        $user = User::find(Auth::user()->id);


        $data['countries'] = $countries;
        $data['user'] = $user;
        return response()->json($data) ;

    }

    public function updateProfile(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender'=> 'required',
            'birthday' => 'date_format:"Y-m-d"',
        ]);

        $page = 'personalinformation';

        if ($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('page', $page);
        }else{
            $user = User::find(Auth::user()->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->nick_name = $request->nick_name;
            $user->country_code = $request->country;
            $user->tel_mobile = $request->mobileNum;
            $user->gender = $request->gender;
            if($request->birthday){
                $user->birthday = $request->birthday;
            }
            //$user->address = $request->address;
            //$user->tel_home = $request->tel_home;
            $user->save();

            return redirect()->route('profile')->with('page', $page)->with('message', 'Profile updated!')->with('status', 'success');
        }
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|max:20',
            'confirm_password'=> 'required|same:new_password'
        ]);

        $page = 'changepassword';

        if (!Hash::check($request->current_password,Auth::user()->password)){
            return back()
                ->withErrors("Current password is wrong, please type again")
                ->with('page', $page);

        }else if ($validator->fails()){
            return back()
                ->withErrors($validator)
                ->with('page', $page);
        }else{
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->route('profile')->with('page', $page)->with('message', 'Password changed!')->with('status', 'success');
        }
    }

    public function changeEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'confirmed_email' => 'required|same:email',
            'password' => 'required'
        ]);

        $page = 'changeemail';

        if (!Hash::check($request->password,Auth::user()->password)){
            return back()
                ->withErrors("Password is wrong, please type again")
                ->with('page', $page);

        }else if ($validator->fails()){
            return back()
                ->withErrors($validator)
                ->with('page', $page);
        }else{
            $user = User::find(Auth::user()->id);
            $user->email = $request->email;
            $user->activated = 0;
            $user->save();

            $this->queueActivationKeyNotification($user);

            Auth::logout();
            return redirect()->route('index')->with('message', 'Please check your email and confirm your email address change.')
                ->with('status', 'success');
        }
    }


    public function updateSubscription(Request $request){
        $user = User::find(Auth::user()->id);
        $user->subscription = $request->subscription;
        $user->save();

        $page = 'subscriptionsetting';

        return redirect()->route('profile')->with('page', $page)->with('message', 'Subscription setting updated!')->with('status', 'success');
    }


    public function changeAvatar(Request $request){
        $validator = Validator::make($request->all(), [
            'avatar'=>'required'
        ]);

        if ($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }else{
            File::makeDirectory(public_path("/avatars"), 0777, true, true);

            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->avatar));
            $filename = Auth::user()->id . '.jpg';
            $path = storage_path("app/public/avatars/" . $filename);
            Images::make($data)->save($path);

            $user = User::find(Auth::user()->id);
            $user->avatar = "public/avatars/" . $filename;
            $user->save();
            return redirect()->route('profile')->with('message', 'Avatar updated!')->with('status', 'success');
        }
    }




};