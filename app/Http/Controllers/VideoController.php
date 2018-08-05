<?php

namespace App\Http\Controllers;


use App\Models\Image;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    public function showIndex()
    {
        $data = array();
        $videoCategories = VideoCategory::where('active', true)->get();
        $userId = 0;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }
        foreach ($videoCategories as $category) {
            $videoList = Video::where('video_category_id', $category->id)
                ->with('image')->with('recipe')->with('category')
                ->with(['users' => function ($q) use ($userId) {
                    $q->select('user_id')->where('user_id', $userId)->first();
                }])
                ->inRandomOrder()->take(8)->get();
            $videoListData['name'] = $category->name;
            $videoListData['slug'] = $category->slug;
            $videoListData['description'] = $category->description;
            $videoListData['videoList'] = $videoList;
            array_push($data, $videoListData);
        }

        //all videos page
        return view('front.video.all-video', compact('data'));
    }

    public function showPlayer(Request $request)
    {
        //video data
        $video = Video::where('slug', $request->slug)->with('image')->firstOrFail();
        $videoSeriesList = Video::where('video_category_id', $video->video_category_id)->with('image')->with('category')->orderBy('id', 'desc')->paginate(10);
        if($request->page > $videoSeriesList->lastPage())
            abort(404);

        return view('front.video.video-player', compact('count', 'video', 'videoSeriesList'));
    }

    public function showVideoSeries(Request $request)
    {

//      if(Auth::check() && Auth::user()->admin)
//        $category = VideoCategory::where('slug', $request->series)->firstOrFail();
//      else
//        $category = VideoCategory::where('slug', $request->series)->where('active',1)->firstOrFail();

      $category = VideoCategory::where('slug', $request->series)->firstOrFail();

        $userId = 0;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $day_of_year = date('z');

      if($category->slug == 'flavology') {
        $videoLists = Video::where('video_category_id', $category->id)
          ->with('image')->with('recipe')->with('category')
          ->with(['users' => function ($q) use ($userId) {
            $q->select('user_id')->where('user_id', $userId)->first();
          }])
          ->orderBy('release_date')->paginate(12);
      } else {
        $videoLists = Video::where('video_category_id', $category->id)
            ->with('image')->with('recipe')->with('category')
            ->with(['users' => function ($q) use ($userId) {
                $q->select('user_id')->where('user_id', $userId)->first();
            }])
            ->orderByRaw('RAND(' . $day_of_year . ')')->paginate(12);
      }

        if($request->page > $videoLists->lastPage())
            abort(404);

//        dd($videoLists->toArray());
        $trailer = false;
        if($category->slug == 'flavology') {
          $trailer = Video::where('id', $category->trailer_video_id)->with('image')->with('category')
            ->with(['users' => function ($q) use ($userId) {
              $q->select('user_id')->where('user_id', $userId)->first();
            }])->first();
        }

        $random_lists = Video::where('video_category_id', $category->id)
            ->with('image')->with('recipe')->with('category')
            ->with(['users' => function ($q) use ($userId) {
                $q->select('user_id')->where('user_id', $userId)->first();
            }])
            ->inRandomOrder()->take(3)->get();

        return view('front.video.video-series', compact('category', 'videoLists', 'random_lists', 'trailer'));

    }

    //
    public function videoWatched(Request $request)
    {

        if ($video = Video::where('slug', $request->slug)->first()) {
            if (!Video::where('slug', $request->slug)->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user()->id);
            })->first()
            ) {
                $video->users()->attach(Auth::user()->id);
                $video->save();
                return '1';
            }

        }
    }


    // generate json data for video player page
    public function getVideoData(Request $request)
    {
        $videoType = 'hls';
        if ($request->ios == "true") {
            $videoType = 'hls';
        }

        $video = Video::where('slug', $request->slug)->with('image')->first();
        $video->src = $video->url(false, $videoType);
        if (Image::where('id', $video->image_id)->exists()) {
            $video->poster = $video->image->url();
        } else {
            $video->poster = "";
        }

        $videoSeriesList = Video::where('video_category_id', $video->video_category_id)->with('image')->with('category')->orderBy('id', 'desc')->paginate(10);

        foreach ($videoSeriesList as $v) {
            $v->src = $v->url(false, $videoType);
            if (Image::where('id', $v->image_id)->exists()) {
                $v->poster = $v->image->url();
            } else {
                $v->poster = "";
            }
            $v->link = "/video/" . $v->category->getSlug() . "/" . $v->slug;
        }
        $data['video'] = $video->toArray();
        $data['videoList'] = $videoSeriesList->toArray();
        return response()->json($data);
    }
}

;