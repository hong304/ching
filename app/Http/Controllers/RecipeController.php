<?php

namespace App\Http\Controllers;

use App\Models\IngredientSection;
use App\Models\Recipe;
use App\Models\RecipeCourse;
use App\Models\RecipeIngredient;
use App\Models\RecipeTag;
use Illuminate\Http\Request;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class RecipeController extends Controller
{
// Show Page with tags
//    public function showIndex(Request $request)
//    {
//        $hotCat = DB::table('recipe_recipe_tag as rrt')
//                ->join('recipe_tags as rt', 'rrt.recipe_tag_id', '=', 'rt.id' )
//                ->select(DB::raw('count(*) as total, rt.id, rt.name'))
//                ->groupBy('rt.id')
//                ->orderBy('total','desc')
//                ->limit(5)
//                ->get();
//
//        $tag = $request->tag;
//        if($tag && RecipeTag::where('id', '=', $tag)->count()){
//            $recipes = Recipe::with(['tags' => function($query) use ($tag) {
//                $query->where('recipe_tags.id',$tag);
//            }])->with('video')->paginate(12);
//
//            return view('front.recipe.recipe',compact('recipes', 'tag', 'hotCat'));
//        }else{
//            $recipes = Recipe::select('id','name','image_id','intro')->with('video')->orderBy('updated_at')->paginate(12);
//            return view('front.recipe.recipe', compact('recipes', 'hotCat'));
//        }
//    }

    //show page with course
    public function redirectShowIndex(Request $request)
    {
        $course = $request->course;
        $keyword = str_replace(' ', '-', trim($request->keyword));

        return \Redirect::route('recipe-search', [$course, $keyword]);
    }

    public function redirectShowRecipeDetail(Request $request)
    {
        $recipe_id = $request->id;
        $recipe = Recipe::find($recipe_id);
        if (!$recipe) {
            return Redirect::route('recipe');
        }
        return \Redirect::route('recipe', $recipe->slug);
    }

    public function showIndex($currentPage)
    {
        $courseList = RecipeCourse::all();
        $day_of_year = date('z');
        $recipes = Recipe::where('active', 1)->orderByRaw('Rand(' . $day_of_year . ')')->paginate(12);
        if ($currentPage > $recipes->lastPage())
            abort(404);

        $course = "";
        $keyword = "";
        if (Cache::has('search_lists')) {
            $lists = Cache::get('search_lists');
        } else {
            $recipeIngredients = RecipeIngredient::select('name');
            $recipeTags = RecipeTag::select('name');

            $lists = $recipeIngredients->union($recipeTags)->get()->pluck('name');
            Cache::put('search_lists', $lists, 120);
        }
        return view('front.recipe.recipe', compact('recipes', 'courseList', 'course', 'keyword', 'lists'));
    }

    public function showSearchResult(Request $request)
    {
        if (!$request->course) {
            return Redirect::route('recipe');
        }
        $courseList = RecipeCourse::all();
        $course_name = $request->course;
        $recipes = Recipe::query();


        $course = '';
        if ($course_name != 'all')
            $course = RecipeCourse::where('slug', $course_name)->pluck('id')->first();

        if ($course && Recipe::where('recipe_course_id', $course)->count()) {
            $recipes = $recipes->with('recipe_course')->where('recipe_course_id', '=', $course);

            if (Cache::has($request->course)) {
                $lists = Cache::get($request->course);
            } else {

                $recipes = $recipes->with('recipe_course')->where('recipe_course_id', '=', $course);

                //auto-complete text list
                $auto_recipes = Recipe::where('recipe_course_id', $course)->pluck('id')->toArray();
                $recipeTags = RecipeTag::select('name')->whereHas('recipes', function ($q) use ($auto_recipes) {
                    $q->wherein('recipe_id', $auto_recipes);
                });
                $recipeIngredients = RecipeIngredient::select('name')->whereHas('recipes', function ($q) use ($auto_recipes) {
                    $q->wherein('recipe_id', $auto_recipes);
                });
                $lists = $recipeIngredients->union($recipeTags)->get()->pluck('name');

                Cache::put($request->course, $lists, 120);
            }


        } else {
            if (Cache::has('search_lists')) {
                $lists = Cache::get('search_lists');
            } else {
                $recipeIngredients = RecipeIngredient::select('name');
                $recipeTags = RecipeTag::select('name');

                $lists = $recipeIngredients->union($recipeTags)->get()->pluck('name');
                Cache::put('search_lists', $lists, 120);
            }


        }

        if ($keyword = $request->keyword) {


            $recipes = $this->search($recipes, str_replace('-', '%', $keyword));


            if (!$recipes->count()) {

                $keywords = explode("-", $keyword);

                $recipes = Recipe::query();

                foreach ($keywords as $v) {
                    $recipes = $this->search($recipes, $v);

                    if (!$recipes->count())
                        break;
                }
            }
        }

        $day_of_year = date('z');
        $recipes = $recipes->where('active', 1)->orderByRaw('Rand(' . $day_of_year . ')')->paginate(12);
        $course = $request->course;

        $keyword = trim(str_replace('-', ' ', $keyword));
        return view('front.recipe.recipe', compact('recipes', 'course', 'courseList', 'keyword', 'lists'));
    }
//    public function getAjax(){
//
//        if (Cache::has('search_lists'))
//        {
//            $lists = Cache::get('search_lists');
//        }
//        else
//        {
//            $recipeIngredients = RecipeIngredient::select('name');
//            $recipeTags = RecipeTag::select('name');
//
//            $lists = $recipeIngredients->union($recipeTags)->get()->pluck('name');
//            Cache::put('search_lists', $lists, 120);
//        }
//
//        return response()->json($lists);
//    }

    //orWhereRaw("soundex(name) = '".soundex($v)."'");
    private function search($collections, $v)
    {
        return $collections->where(function ($q1) use ($v) {
            $q1->whereHas('ingredients', function ($q) use ($v) {
                $q->where('name', 'LIKE', "%$v%");
            })->orWhereHas('tags', function ($q) use ($v) {
                $q->where('name', 'LIKE', "%$v%")->orWhereRaw("soundex(name) = '" . soundex($v) . "'");
            })->orWhere('name', 'LIKE', "%$v%");
        });
    }

    public function showRecipeDetails(Request $request)
    {

        if ($request->slug) {
            //get recipe details
            $recipe = Recipe::queryBySlug($request->slug)
                ->with('recipe_course')
                ->with('ingredients')
                ->with('sections')
                ->with('steps')
                ->with('image')
                ->with('video')
                ->with('nutrition')
                ->with('tags')
                ->with('source');

            if (!Auth::check() || !\Auth::user()->admin) {
                $recipe = $recipe->where('active', 1);
            }


            $recipe = $recipe->firstOrFail();

            $random_related_recipe = Recipe::where('id', '!=', $recipe->id)->where('recipe_course_id', $recipe->recipe_course_id)->where('active', 1)->inRandomOrder()->take(3)->get();

            //get recipe ingredients details
            $recipeIngredients = $recipe->ingredients->toArray();
            $iSections = $recipe->sections->toArray();

            $ingredientSections = array();
            foreach ($iSections as $s) {
                $ingredientSections[$s['id']] = $s['name'];
            }
            $ingredients = array();
            foreach ($ingredientSections as $key => $ins) {
                $tempArray['section'] = $ins;
                $tempArray['ingredients'] = [];
                for ($i = 0; $i < count($recipeIngredients); $i++) {
                    if ($iSections[$i]['id'] == $key) {
                        $ingredient['name'] = $recipeIngredients[$i]['name'];
                        $ingredient['unit'] = $recipeIngredients[$i]['pivot']['unit'];
                        array_push($tempArray['ingredients'], $ingredient);
                    }
                }
                array_push($ingredients, $tempArray);
            }

//            $section = IngredientSection::with(['ingredients'=>function($q){
//                $q->where('recipe_ingredient_id',8)->with(['recipes'=>function($q){
//                    $q->where('recipe_id','=',1)->where('recipe_ingredient_id',8);
//                }]);
//            }])
//
//
//                ->whereHas('recipes',function($q){
//                $q->where('recipe_id',1)->where('recipe_ingredient_id',8);
//            })
//
//                ->get()->toArray();

//            $section = IngredientSection::with(['ingredients'=>function($q){
//                $q->where('recipe_ingredient_id',8);
//            }])->with(['recipes'=>function($q){
//                $q->where('recipe_id','=',1)->where('recipe_ingredient_id',8);
//            }])
//
//
//                ->whereHas('recipes',function($q){
//                    $q->where('recipe_ingredient_id',8)->where('recipe_id','=',1);
//                })
//
//                ->get()->toArray();
          $slug = $request->slug;


            return view('front.recipe.recipe-details', compact('recipe', 'ingredients', 'random_related_recipe', 'slug'));

        } else {
            return $this->showIndex($request->page);
        }
    }


    public function showRecipePrint(Request $request)
    {

        if ($request->slug) {
            //get recipe details
            $recipe = Recipe::queryBySlug($request->slug)
                ->with('recipe_course')
                ->with('ingredients')
                ->with('sections')
                ->with('steps')
                ->with('image')
                ->with('video')
                ->with('nutrition')
                ->with('tags')
                ->firstOrFail();


            //get recipe ingredients details
            $recipeIngredients = $recipe->ingredients->toArray();
            $iSections = $recipe->sections->toArray();

            $ingredientSections = array();
            foreach ($iSections as $s) {
                $ingredientSections[$s['id']] = $s['name'];
            }
            $ingredients = array();
            foreach ($ingredientSections as $key => $ins) {
                $tempArray['section'] = $ins;
                $tempArray['ingredients'] = [];
                for ($i = 0; $i < count($recipeIngredients); $i++) {
                    if ($iSections[$i]['id'] == $key) {
                        $ingredient['name'] = $recipeIngredients[$i]['name'];
                        $ingredient['unit'] = $recipeIngredients[$i]['pivot']['unit'];
                        array_push($tempArray['ingredients'], $ingredient);
                    }
                }
                array_push($ingredients, $tempArray);
            }

            return view('front.recipe.recipe-print', compact('recipe', 'ingredients'));

        }

    }


}

;