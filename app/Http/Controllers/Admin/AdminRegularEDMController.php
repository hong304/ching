<?php

namespace App\Http\Controllers;

use App\Mail\RegularEdmMail;
use App\Models\Image;
use App\Models\IngredientType;
use App\Models\RecipeIngredient;
use App\Models\RecipeIngredientSection;
use App\Models\RegularEDM;
use App\Models\RegularEdmUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageServiceProvider;
use Intervention\Image\Response;
use Yajra\Datatables\Facades\Datatables;

class AdminRegularEDMController extends Controller
{

    public function showIndex()
    {
        return view('admin.regular-edm.edm-list');
    }

    public function ajaxGetEdmData(Request $request)
    {
        $edm = RegularEDM::select('id', 'name', 'no_of_sent', 'created_at', 'updated_at');

        return Datatables::of($edm)
            ->addColumn('count', function ($edm) {
                return RegularEdmUser::where('edm_id', $edm->id)->count();
            })
            ->addColumn('edit', function ($edm) {
                return '<a href="' . route("adminEdm.edit", $edm->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            })
            ->addColumn('delete', function ($edm) {
                if ($edm->no_of_sent == 0) {
                    return '<a href="javascript:void(0);" onclick="deleteEDM(' . $edm->id . ')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                }
                return "-";
            })
            ->addColumn('preview', function ($edm) {
                return '<a href="' . route("adminEdm.preview", $edm->id) . '" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Preview</a>';
            })
            ->addColumn('send', function ($edm) {
                if (Auth::id() == env('CHING_ID')){
                    return "-";
                }
                return '<a href="' . route("adminEdm.send", $edm->id ) . '"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send</a>';
            })
            ->make();
    }

    public function showEditEDM(Request $request)
    {
        $edm = RegularEDM::with('blogImage')
            ->with('instagramImage1')
            ->with('instagramImage2')
            ->with('instagramImage3')
            ->with('instagramImage4')
            ->with('recipeImage')
            ->where('id', $request->id)
            ->first();

        if ($edm->blog_date != null) {
            $edm->blog_date = date('Y-m-d', strtotime($edm->blog_date));
        }
        return view('admin.regular-edm.edit-edm', compact('edm'));
    }

    public function editEDM(Request $request)
    {
        if ($request->id) { //edit
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'edm_section' => 'required',
                'subject' => 'required',
                'header_title' => 'required_with:edm_section.0',
                'header_content' => 'required_with:edm_section.0',
                'blog_title' => 'required_with:edm_section.1',
                'blog_image' => 'image|mimes:jpeg,png,jpg|max:1024',
                'blog_image_alt' => 'required_with:edm_section.1',
                'blog_link' => 'required_with:edm_section.1|url',
                'blog_date' => 'required_with:edm_section.1',
                'blog_intro' => 'required_with:edm_section.1',
                'instagram_image_1' => 'image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_1' => 'required_with:edm_section.2',
                'instagram_link_1' => 'required_with:edm_section.2|url',
                'instagram_image_2' => 'image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_2' => 'required_with:edm_section.2',
                'instagram_link_2' => 'required_with:edm_section.2|url',
                'instagram_image_3' => 'image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_3' => 'required_with:edm_section.2',
                'instagram_link_3' => 'required_with:edm_section.2|url',
                'instagram_image_4' => 'image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_4' => 'required_with:edm_section.2',
                'instagram_link_4' => 'required_with:edm_section.2|url',
                'recipe_title' => 'required_with:edm_section.3',
                'recipe_image' => 'image|mimes:jpeg,png,jpg|max:1024',
                'recipe_image_alt' => 'required_with:edm_section.3',
                'recipe_link' => 'required_with:edm_section.3|url',
                'recipe_intro' => 'required_with:edm_section.3',
            ]);
        } else { //create
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'edm_section' => 'required',
                'subject' => 'required',
                'header_title' => 'required_with:edm_section.0',
                'header_content' => 'required_with:edm_section.0',
                'blog_title' => 'required_with:edm_section.1',
                'blog_image' => 'required_with:edm_section.1|image|mimes:jpeg,png,jpg|max:1024',
                'blog_image_alt' => 'required_with:edm_section.1',
                'blog_link' => 'required_with:edm_section.1|url',
                'blog_date' => 'required_with:edm_section.1',
                'blog_intro' => 'required_with:edm_section.1',
                'instagram_image_1' => 'required_with:edm_section.2|image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_1' => 'required_with:edm_section.2',
                'instagram_link_1' => 'required_with:edm_section.2|url',
                'instagram_image_2' => 'required_with:edm_section.2|image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_2' => 'required_with:edm_section.2',
                'instagram_link_2' => 'required_with:edm_section.2|url',
                'instagram_image_3' => 'required_with:edm_section.2|image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_3' => 'required_with:edm_section.2',
                'instagram_link_3' => 'required_with:edm_section.2|url',
                'instagram_image_4' => 'required_with:edm_section.2|image|mimes:jpeg,png,jpg|max:1024',
                'instagram_image_alt_4' => 'required_with:edm_section.2',
                'instagram_link_4' => 'required_with:edm_section.2|url',
                'recipe_title' => 'required_with:edm_section.3',
                'recipe_image' => 'required_with:edm_section.3|image|mimes:jpeg,png,jpg|max:1024',
                'recipe_image_alt' => 'required_with:edm_section.3',
                'recipe_link' => 'required_with:edm_section.3|url',
                'recipe_intro' => 'required_with:edm_section.3',
            ]);
        }


        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $successMessage = "EDM is created.";
        $edm = new RegularEDM();
        if ($request->id) {
            $edm = RegularEDM::find($request->id);
            $successMessage = "EDM is edited.";
        }

        $edm->name = $request->name;
        $edm->subject = $request->subject;
        if (isset($request->edm_section[0])) {
            $edm->header_title = $request->header_title;
            $edm->header_content = $request->header_content;
        } else {
            $edm->header_title = null;
            $edm->header_content = null;
        }

        if (isset($request->edm_section[1])) {
            $edm->blog_title = $request->blog_title;
            $edm->blog_link = $request->blog_link;
            $edm->blog_date = $request->blog_date;
            $edm->blog_intro = $request->blog_intro;
            $edm->blog_image_alt = $request->blog_image_alt;

            if ($request->file('blog_image')) {
                if ($edm->blog_image_id) {
                    Image::destroy($edm->blog_image_id);
                }
                $blog_image_id = Image::newImageToCDN($request->file('blog_image'));
                if ($blog_image_id) {
                    $edm->blog_image_id = $blog_image_id;
                } else {
                    return back()
                        ->withErrors("Blog Image Upload Failed, please upload again.")
                        ->withInput();
                }
            }

        } else {
            $edm->blog_title = null;
            $edm->blog_link = null;
            $edm->blog_date = null;
            $edm->blog_intro = null;
            $edm->blog_image_id = null;
            $edm->blog_image_alt = null;
        }
        if (isset($request->edm_section[2])) {
            for ($i = 1; $i <= 4; $i++) {
                $link = "instagram_link_" . $i;
                $imageId = "instagram_image_id_" . $i;
                $altTxt = "instagram_image_alt_" .$i;

                $edm->$link = $request->$link;
                $edm->$altTxt = $request->$altTxt;

                if ($request->file('instagram_image_' . $i)) {
                    if ($edm->$imageId) {
                        Image::destroy($edm->$imageId);
                    }
                    $instagram_image = Image::newImageToCDN($request->file('instagram_image_' . $i));
                    if ($instagram_image) {
                        $edm->$imageId = $instagram_image;
                    } else {
                        return back()
                            ->withErrors("Instagram image " . $i . " Upload Failed, please upload again.")
                            ->withInput();
                    }
                }
            }
        } else {
            for ($i = 1; $i <= 4; $i++) {
                $link = "instagram_link_" . $i;
                $imageId = "instagram_image_id_" . $i;
                $altTxt = "instagram_image_alt_" .$i;

                $edm->$link = null;
                $edm->$imageId = null;
                $edm->$altTxt = null;
            }
        }
        if (isset($request->edm_section[3])) {
            $edm->recipe_title = $request->recipe_title;
            $edm->recipe_link = $request->recipe_link;
            $edm->recipe_intro = $request->recipe_intro;
            $edm->recipe_image_alt = $request->recipe_image_alt;

            if ($request->file('recipe_image')) {
                if ($edm->recipe_image_id) {
                    Image::destroy($edm->recipe_image_id);
                }
                $recipe_image_id = Image::newImageToCDN($request->file('recipe_image'));
                if ($recipe_image_id) {
                    $edm->recipe_image_id = $recipe_image_id;
                } else {
                    return back()
                        ->withErrors("Recipe Image Upload Failed, please upload again.")
                        ->withInput();
                }
            }
        } else {
            $edm->recipe_title = null;
            $edm->recipe_link = null;
            $edm->recipe_intro = null;
            $edm->recipe_image_id = null;
            $edm->recipe_image_alt = null;
        }

        $edm->save();

        return redirect()
            ->route('adminEdm.index')
            ->with('message', $successMessage)
            ->with('status', 'success');
    }

    public function showCreateEDM(Request $request)
    {
        return view('admin.regular-edm.create-edm');
    }

    public function deleteEDM(Request $request)
    {
        $edm = RegularEDM::find($request->id);
        if ($edm->no_of_send == 0) {

            Image::destroy($edm->blog_image_id);
            Image::destroy($edm->instagram_image_id_1);
            Image::destroy($edm->instagram_image_id_2);
            Image::destroy($edm->instagram_image_id_3);
            Image::destroy($edm->instagram_image_id_4);
            Image::destroy($edm->recipe_image_id);

            RegularEDM::destroy($request->id);

            return redirect()
                ->route('adminEdm.index')
                ->with('message', 'EDM with id ' . $request->id . ' is deleted.')
                ->with(('status'), 'success');
        }

        return redirect()
            ->route('adminEdm.index')
            ->withErrors("This EDM had been sent out before, you cannot delete it.");


    }

    public function previewEDM(Request $request)
    {

        $edm = RegularEDM::with('blogImage')
            ->with('instagramImage1')
            ->with('instagramImage2')
            ->with('instagramImage3')
            ->with('instagramImage4')
            ->with('recipeImage')
            ->where('id', $request->id)
            ->first();

        if ($edm->blog_date != null) {
            $edm->blog_date = date('d/m/Y', strtotime($edm->blog_date));
        }
        return view('emails.regular-edm', compact('edm'));
    }

    public  function showSendEDM(Request $request)
    {
        if (Auth::id() == env('CHING_ID')){
            return redirect()->route('adminEdm.index');
        }
        $id = $request->id;
        return view('admin.regular-edm.send-edm', compact('id'));
    }

    public  function sendTestEDM(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_emails' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $edm = RegularEDM::with('blogImage')
            ->with('instagramImage1')
            ->with('instagramImage2')
            ->with('instagramImage3')
            ->with('instagramImage4')
            ->with('recipeImage')
            ->where('id', $request->id)
            ->first();

        if ($edm->blog_date != null) {
            $edm->blog_date = date('d/m/Y', strtotime($edm->blog_date));
        }
        $edm->userId = 0;

        $message = (new RegularEdmMail($edm))->onConnection('database')->onQueue('emails');

        $emailArray = explode(",", $request->test_emails);
        foreach ($emailArray as $email){
            Mail::to(trim($email))
                ->queue($message);
        }

        return redirect()
            ->route('adminEdm.index')
            ->with('message','EDM with id ' . $request->id . ' is sent for test.')
            ->with('status', 'success');

    }


    public function sendEDM(Request $request)
    {
        $edm = RegularEDM::with('blogImage')
            ->with('instagramImage1')
            ->with('instagramImage2')
            ->with('instagramImage3')
            ->with('instagramImage4')
            ->with('recipeImage')
            ->where('id', $request->id)
            ->first();

        $edm->no_of_sent = $edm->no_of_sent + 1;
        $edm->save();

        if ($edm->blog_date != null) {
            $edm->blog_date = date('d/m/Y', strtotime($edm->blog_date));
        }


        User::select('id', 'email')->where('activated', true)->chunk(1000, function ($emailList) use ($edm){

            foreach ($emailList as $email){
                $edm->userId = $email['id'];
                $message = (new RegularEdmMail($edm))->onConnection('database')->onQueue('emails');
                Mail::to($email['email'])
                    ->queue($message);
            }
        });

        return redirect()
            ->route('adminEdm.index')
            ->with('message', 'EDM with id ' . $request->id . ' is sent.')
            ->with(('status'), 'success');


//        for ($i =1 ; $i <=100 ;$i++){
//            Mail::to('hl@buildonauts.com')
//                ->queue($message);
//        }

//        Mail::to('hl@buildonauts.com')
//            ->cc('hong304@gmail.com')
//            ->queue($message);
//
//        Mail::to('cc@buildonauts.com')
//            ->queue($message);
    }
    public function edmWatchCount(Request $request){


        $edmUser = RegularEdmUser::where('edm_id', $request->edmId)->where('user_id', $request->uid)->first();
        if ($edmUser){
            $edmUser->count = $edmUser->count +1;
            $edmUser->save();
        }else{
            $edmUser = new RegularEdmUser();
            $edmUser->user_id = $request->uid;
            $edmUser->edm_id = $request->edmId;
            $edmUser->count = 1;
            $edmUser->save();
        }

        $img = \Images::canvas(1, 1, '#3FB0AD');
        return $img->response('png', 70);
    }
}

;