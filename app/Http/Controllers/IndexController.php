<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Recipe;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use MaxMind\Db\Reader;
use Session;
use App;
use URL;

class IndexController extends Controller
{

    public function getTest()
    {

        \DB::transaction(function () {


            $recipe = New Recipe();
            $recipe->active = 1;
            $recipe->recipe_course_id = 1;
            $recipe->name = 'Testing';
            $recipe->slug = 'Slugwfaegsrdf';
            $recipe->intro = 'Intro';
            $recipe->tips = 'Tips';
            $recipe->preparation_time = 1;
            $recipe->cooking_time = 1;
            $recipe->save();


            $steps = [
                'step1', 'step2'
            ];


            foreach ($steps as $k => $v) {
                $step = New App\Models\RecipeStep();
                $step->recipe_id = $recipe->id;
                $step->step_order = $k;
                $step->instruction = $v;
                $step->save();
            }

            $tags = [1, 2, 3, 'bb', 4, 'gg'];
            foreach ($tags as $k => $v) {
                if (is_numeric($v)) {
                    $tag_to_db[] = $v;
                    unset($tags[$k]);
                } else {
                    $new_tag = New App\Models\RecipeTag();
                    $new_tag->name = $v;
                    $new_tag->save();
                    $tag_to_db[] = $new_tag->id;
                }

            }

            $nutrition = New App\Models\Nutrition();
            $nutrition->cals = 1;
            $nutrition->protein = 1;
            $nutrition->carbs = 1;
            $nutrition->sugars = 1;
            $nutrition->fat = 1;
            $nutrition->satfat = 1;
            $nutrition->fibre = 1;
            $nutrition->sodium = 1;
            $nutrition->recipe_id = $recipe->id;
            $nutrition->save();


            $recipe->tags()->sync($tag_to_db);


            $section[1][0] = [
                'recipe_ingredient_id' => 1,
                'unit' => 'a spring'
            ];

            $section[1][1] = [
                'recipe_ingredient_id' => 2,
                'unit' => '2 cloves, crushed and finely chopped'
            ];

            $section[2][0] = [
                'recipe_ingredient_id' => 1,
                'unit' => '80g / 0.17 lb'
            ];


            foreach ($section as $k => $s) {

                foreach ($s as $breakdown) {
                    $ris = New App\Models\RecipeIngredientSection();
                    $ris->recipe_id = $recipe->id;
                    $ris->unit = $breakdown['unit'];
                    $ris->recipe_ingredient_id = $breakdown['recipe_ingredient_id'];
                    $ris->ingredient_section_id = $k;
                    $ris->save();
                }
            }

//
//        $a['s1']['ingredient_id'] = [
//            '1','2','3','4'
//        ];
//
//        $a['s1']['unit'] =[
//            'h','e','l','l'
//        ];

            // $recipe->ingredients()->attach([ 2=>[ 'recipe_section_id' => 1, 'unit' => 'hi' ]  ]);
        }, 3);

    }


    public function ajaxSetCount()
    {
        $count = 1;
        if (Auth()->guest()) {
            if (Session::has('count')) {
                $count = Session::get('count');
                Session::put('count', Session::get('count') + 1);
                $count += 1;
            } else {
                Session::put('count', 1);
            }
        }
        return response()->json(['count' => $count]);
    }

    public function showIndex()
    {
        $recipes = Recipe::where('active', 1)->inRandomOrder()->take(8)->get();
        $latestVideoList = Video::where('video_category_id', 1)->with('image')->with('category')->take(8)->get();
//        $client = new \GuzzleHttp\Client();
//        $url = "https://www.instagram.com/chinghehuang/media";
//        $response = $client->get($url);
//
//        $items = json_decode((string)$response->getBody(), true)['items'];


        return view('front.home.home', compact('recipes', 'latestVideoList'));
    }

    public static function ajaxCloseCookieAction()
    {
        Cookie::queue('closeCookie', true, 0);
    }

    public function getHome()
    {
        return view('front.home.home');
    }

    public function getSearch(Request $request)
    {


        $v = str_replace(' ', '%', $request->keyword);

        $recipes = Recipe::select('name as title', 'slug', 'intro as content')->where(function ($q1) use ($v) {
            $q1->whereHas('ingredients', function ($q) use ($v) {
                $q->where('name', 'LIKE', "%$v%");
            })->orWhereHas('tags', function ($q) use ($v) {
                $q->where('name', 'LIKE', "%$v%");
            })->orWhere('name', 'LIKE', "%$v%")->orWhere('intro', 'LIKE', "%$v%");
        })->get();

        // $count = count($recipes);
//        echo "recipe".$count."<br>";


        $blogs = Blog::select('title', 'slug', 'content')->where('title', 'LIKE', "%$v%")->orWhere('content', 'LIKE', "%$v%")->get();
//        $count += count($blogs);


        // dd($blogs->getSearchTitle(explode(" ",$request->keyword)));

//        echo "blog".$count."<br>";

        $videos = Video::select('name as title', 'slug', 'description as content')->where('name', 'LIKE', "%$v%")->orWhere('description', 'LIKE', "%$v%")->get();

//        $count += count($videos);
//        echo "video".$count."<br>";

        $collection = collect();

        $collection = $collection->merge($recipes)->merge($blogs)->merge($videos);

//        foreach ($recipes as $v)
//            $collection->push($v);
//        foreach ($blogs as $blog)
//            $collection->push($blog);
//        foreach ($videos as $video)
//            $collection->push($video);

        foreach ($collection as $k => $v) {
            //dump(class_basename($v));
        }

        //  dd($collection->toArray());

        return view('front.home.global-search')->with('result', $collection->all())->with('keyword', $request->keyword);

    }
}

;