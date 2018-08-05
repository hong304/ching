<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
	public function showIndex()
	{
		$now = date('y-m-d');
		$oneWeekBefore = date('Y-m-d', strtotime('-7 days'));
		$oneMonthBefore = date('Y-m-d', strtotime('-1 month'));
		
		$data = array();
		$data['registerWeekCount'] = User::whereBetween('created_at', [$oneWeekBefore, $now])->count();
		$data['registerMonthCount'] = User::whereBetween('created_at', [$oneMonthBefore, $now])->count();
		$data['registerTotalCount'] = User::all()->count();
		
		$data['activationWeekCount'] = User::whereBetween('activation_time', [$oneWeekBefore, $now])->count();
		$data['activationMonthCount'] = User::whereBetween('activation_time', [$oneMonthBefore, $now])->count();
		$data['activationTotalCount'] = User::where('activated', true)->count();
		
		$data['activeUserWeekCount'] = User::whereBetween('last_login_time', [$oneWeekBefore, $now])->count();
		$data['activeUserMonthCount'] = User::whereBetween('last_login_time', [$oneMonthBefore, $now])->count();
		
		$data['facebookLoginCount'] = User::whereNotNull('facebook_id')->count();
		
		$data['subscriptionWeekCount'] = Subscription::where('verified', true)->whereBetween('created_at', [$oneWeekBefore, $now])->count();
		$data['subscriptionMonthCount'] = Subscription::where('verified', true)->whereBetween('created_at', [$oneMonthBefore, $now])->count();
		$data['subscriptionTotalCount'] = Subscription::where('verified', true)->count() + User::where('activated', true)->where('subscription', true)->count();
		
		$registerPerMonth = DB::table('users')
			->select(DB::raw('count(*) as total, YEAR(`created_at`) as year, MONTH(`created_at`) as month'))
			->groupBy('year')
			->groupBy('month')
			->where('created_at', '>', date('2017-03-17') . ' 12:00:00')
            ->get();

        $data['registerPerMonthXLabels'] = [];

        foreach ($registerPerMonth as $register) {
	        $label = $register->year . "/" . $register->month;
	        array_push($data['registerPerMonthXLabels'], $label);
        }

        $data['registerPerMonth'] = $registerPerMonth->pluck('total')->toJson();


        $activationPerMonth = DB::table('users')
	        ->select(DB::raw('count(*) as total, YEAR(`activation_time`) as year, MONTH(`activation_time`) as month'))
	        ->whereNotNull('activation_time')
	        ->groupBy('year')
	        ->groupBy('month')
	        ->get();


        $data['activationPerMonthXLabels'] = [];

        foreach ($activationPerMonth as $activation) {
	        $label = $activation->year . "/" . $activation->month;
	        array_push($data['activationPerMonthXLabels'], $label);
        }
        $data['activationPerMonth'] = $activationPerMonth->pluck('total')->toJson();


        return view('admin.dashboard', compact('data'));
    }
	
	public function getLog()
	{
		return response()->download(storage_path("logs/laravel.log"));
	}
}

;