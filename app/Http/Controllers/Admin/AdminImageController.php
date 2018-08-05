<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Image;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminImageController extends Controller
{

    public function showIndex(Request $request)
    {
        $imageCategories = array("other", "blog", "recipe", "video", "upload");
        $currentCategory = $request->cat;
        switch ($currentCategory) {
            case "blog":
                $query = Blog::query();
                break;
            case "recipe":
                $query = Recipe::query();
                break;
            case "video":
                $query = Video::query();
                break;
            case "upload":
                return view('admin.image.image-list', compact('currentCategory', 'imageCategories'));
                break;
            case "other":
            default:
                $blogImageID = Blog::whereNotNull('image_id')->pluck('image_id')->toArray();
                $recipeImageID = Recipe::whereNotNull('image_id')->pluck('image_id')->toArray();
                $videoImageID = Video::whereNotNull('image_id')->pluck('image_id')->toArray();
                $allImagesID = array_unique(array_merge($blogImageID, $recipeImageID, $videoImageID));
                $imagesArr = Image::whereNotIn('id', $allImagesID)
                    ->where('sub_dir', "<>", "images_static")
                    ->whereDate('created_at', '>', Carbon::createFromDate(2017,4,1 ) )
                    ->orderby('created_at', 'desc')->paginate(30);
                return view('admin.image.image-list', compact('imagesArr', 'currentCategory', 'imageCategories'));
        }
        $imagesID = $query->whereNotNull('image_id')->pluck('image_id')->toArray();
        $imagesArr = Image::whereIn('id', $imagesID)->orderby('created_at', 'desc')->paginate(30);

        return view('admin.image.image-list', compact('imagesArr', 'currentCategory', 'imageCategories'));
    }

    public function deleteImage(Request $request)
    {
        Image::destroy($request->image_id);

        return redirect()
            ->route('adminImage.index')
            ->with('message', 'Image with id ' . $request->image_id . ' is deleted.')
            ->with('status', 'success');
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload_image' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $new_image = $request->file('upload_image');
            $image_id = Image::newImageToCDN($new_image);
            if (!$image_id) {
                return back()
                    ->withErrors("Image Upload Failed, please upload again.")
                    ->withInput();
            }
        }

        return redirect()
            ->route('adminImage.index', "other")
            ->with('message', 'Image is uploaded.')
            ->with('status', 'success');
    }

    public function ajaxGetImageData(Request $request)
    {
        switch ($request->type) {
            case "blog":
                $query = Blog::query();
                break;
            case "recipe":
                $query = Recipe::query();
                break;
            case "video":
                $query = Video::query();
                break;
            case "other":
                $blogImageID = Blog::whereNotNull('image_id')->pluck('image_id')->toArray();
                $recipeImageID = Recipe::whereNotNull('image_id')->pluck('image_id')->toArray();
                $videoImageID = Video::whereNotNull('image_id')->pluck('image_id')->toArray();
                $allImagesID = array_unique(array_merge($blogImageID, $recipeImageID, $videoImageID));
                $otherImages = Image::whereNotIn('id', $allImagesID)->where('sub_dir', "<>", "images_static")->orderby('created_at', 'desc')->paginate(15);
                if ($otherImages->lastPage() >= (int)$request->page) {
                    $otherImages = $this->generateImagesJsonArray($otherImages);
                    return response()->json($otherImages);
                } else {
                    return response()->json(array(
                        'status' => 'success',
                        'message' => 'There is no more images in this category.'
                    ));
                }
                break;
            default:
                return response()->json(array(
                    'status' => 'error',
                    'message' => 'Type is not found.'
                ));
        }

        $imagesID = $query->whereNotNull('image_id')->pluck('image_id')->toArray();
        $imagesArr = Image::whereIn('id', $imagesID)->orderby('created_at', 'desc')->paginate(15);
        if ($imagesArr->lastPage() >= (int)$request->page) {
            $imagesArr = $this->generateImagesJsonArray($imagesArr);
            return response()->json($imagesArr);
        } else {
            return response()->json(array(
                'status' => 'success',
                'message' => 'There is no more images in this category.'
            ));
        }

//        return response()->json($imagesArr);
    }

    public function generateImagesJsonArray($ImagesArr)
    {
        foreach ($ImagesArr as $image) {
            $image->small_image_url = $image->url(false, "small");
            $image->original_image_url = $image->url(false, "original");
        }
        return $ImagesArr;
    }
}

;