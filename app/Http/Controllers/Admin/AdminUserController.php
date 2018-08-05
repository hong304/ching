<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Image;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminUserController extends Controller
{

    public function showIndex()
    {
        return view('admin.user.user-list');
    }

    public function ajaxGetUserData(Request $request)
    {
        $users = User::select(['admin','id', 'email', 'first_name', 'last_name', 'activated', 'subscription', 'last_login_time' ,'created_at']);
        return Datatables::of($users)
            ->addColumn('edit', function ($user) {
                if (Auth::id()== env('CHING_ID')){
                    return "-";
                }
                return '<a href="'.route("adminUser.edit", $user->id).'" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            })
            ->editColumn('admin', function ($user){
                if ($user->admin){
                    return '<i class="fa fa-check text-color main" aria-hidden="true"></i>';
                }
                return '-';
            })
            ->editColumn('activated', function ($user){
                if ($user->activated){
                    return '<i class="fa fa-check text-color main" aria-hidden="true"></i>';
                }
                return '<i class="fa fa-times text-color error" aria-hidden="true"></i>';
            })
            ->editColumn('subscription', function ($user){
                if ($user->subscription){
                    return '<i class="fa fa-check text-color main" aria-hidden="true"></i>';
                }
                return '<i class="fa fa-times text-color error" aria-hidden="true"></i>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('startDate')) {
                    $query->where('created_at', '>=', $request->get('startDate'));
                }

                if ($request->has('endDate')) {
                    $query->where('created_at', '<=', $request->get('endDate'));
                }

                if ($request->has('activated')) {
                    $query->where('activated', $request->get('activated'));
                }
                if ($request->has('search')) {
                    $query->where(function ($query) use($request) {
                        $query->where('email', 'LIKE','%'.$request->get('search')['value'].'%')->orwhere('first_name', 'LIKE','%'.$request->get('search')['value'].'%')
                            ->orwhere('last_name', 'LIKE','%'.$request->get('search')['value'].'%');
                    });
                }
            })
            ->make();
    }

    public function showEditUser(Request $request){

        if (Auth::id()== env('CHING_ID')){
            return redirect()->route('adminUser.index');
        }

        $user = User::find($request->id);


        return view('admin.user.edit-user',compact('user'));
    }

    public function editUser(Request $request){
        if (Auth::id()== env('CHING_ID')){
            return redirect()->route('adminUser.index');
        }
        $user = User::find($request->id);
        $user->admin = $request->admin;
        $user->activated = $request->activated;
        $user->save();

        return redirect()
            ->route('adminUser.index')
            ->with('message', 'User is edited.')
            ->with('status', 'success');

    }
};