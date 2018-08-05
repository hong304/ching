<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\IngredientSection;
use App\Models\IngredientType;
use App\Models\Nutrition;
use App\Models\Recipe;
use App\Models\RecipeCourse;
use App\Models\RecipeIngredientSection;
use App\Models\RecipeSource;
use App\Models\RecipeStep;
use App\Models\RecipeTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminRecipeController extends Controller
{

    public function showIndex()
    {
        return view('admin.recipe.recipe-list');
    }

    public function ajaxGetRecipeData(Request $request)
    {
        $recipe = Recipe:: select(['id', 'name', 'active', 'created_at', 'updated_at', 'slug']);
        return Datatables::of($recipe)
            ->addColumn('edit', function ($recipe) {
                if ($recipe->id > 142) {
                    return '<a href="' . route("adminRecipes.edit", $recipe->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                return "-";
            })
            ->addColumn('preview', function ($recipe) {
                if (!$recipe->active && $recipe->id > 142) {
                    return '<a href="' . route("recipe", $recipe->slug) . '" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Preview</a>';
                }
                return "-";
            })
            ->editColumn('name', function ($recipe) {
                return '<a target="_blank" href="' . route("recipe", $recipe->slug) . '" >' . $recipe->name . '</a>';
            })
            ->editColumn('active', function ($recipe) {
                if ($recipe->active) {
                    return '<i class="fa fa-check text-color main" aria-hidden="true"></i>';
                }
                return '<i class="fa fa-times text-color error" aria-hidden="true"></i>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('startDate')) {
                    $query->where('created_at', '>=', $request->get('startDate'));
                }

                if ($request->has('endDate')) {
                    $query->where('updated_at', '<=', $request->get('endDate'));
                }

                if ($request->has('active')) {
                    $query->where('active', $request->get('active'));
                }

                if ($request->has('search')) {
                    $query->where('name', 'LIKE', '%' . $request->get('search')['value'] . '%');
                }
            })
            ->make();
    }

    public function showEditRecipe(Request $request)
    {
        if ($request->id <= 142) {
            return redirect()->route('adminRecipes.index');
        }

        $this->generateSession($request->id);

        if (session()->exists('validation')) {
            return $this->routeToStep($request->step, false, true);
        }

        return $this->routeToStep($request->step, false);
    }

    public function showCreateRecipe(Request $request)
    {
        $this->generateSession();

        if ($request->validation) {
            return $this->routeToStep($request->step, true, true);
        }
        return $this->routeToStep($request->step);

    }

    public function createRecipe(Request $request)
    {
        $step = $request->step;
        if ($request->recipe_id) {
            $action = "edit";
            $id = $request->recipe_id;
        } else {
            $action = "create";
            $id = null;
        }
        switch ($step) {
            case '1':

                $step1Value = $request->all();
                if ($request->file('recipe_image')) {
                    $step1Value = $request->except('recipe_image');
                    File::makeDirectory(public_path("/temp_recipe"), 0777, true, true);
                    $step1Value['image_path'] = Storage::putFile('public/temp_recipe', $request->file('recipe_image'));;
                }


                if ($step1Value['scheduled_date']) {
                    $publishTime = new \DateTime($step1Value['scheduled_date']);
                    $publishHour = ($step1Value['scheduled_hour']) ? $step1Value['scheduled_hour'] : 0;
                    $publishMinute = ($step1Value['scheduled_minute']) ? $step1Value['scheduled_minute'] : 0;
                    $publishTime = $publishTime->setTime($publishHour, $publishMinute, 0);
                    $step1Value['publish_at'] = $publishTime->format('Y-m-d H:i:s');
                } else {
                    $step1Value['publish_at'] = null;
                }

                session([$action . '_recipe_step1' => $step1Value]);

                return redirect()->route('adminRecipes.' . $action, ['id' => $id, 'step' => 'step2']);


                break;
            case '2':
                session([$action . '_recipe_step2' => $request->all()]);

                return redirect()->route('adminRecipes.' . $action, ['id' => $id, 'step' => 'step3']);

                break;
            case '3':
                session([$action . '_recipe_step3' => $request->all()]);
                $validateRecipe = $this->validateRecipe($action);
                if ($validateRecipe !== true) {
                    session(['validation' => $validateRecipe]);
                    return redirect()->route('adminRecipes.' . $action, ['id' => $id, 'step' => $validateRecipe]);
                }else{
                    session()->forget('validation');
                }
                break;
        }

        return $this->saveRecipe($request);
    }

    public function createDraftRecipe(Request $request)
    {
        $step = $request->step;
        if ($request->recipe_id) {
            $action = "edit";
            $id = $request->recipe_id;
        } else {
            $action = "create";
            $id = null;
        }
        switch ($step) {
            case '1':

                $step1Value = $request->all();
                if ($request->file('recipe_image')) {
                    $step1Value = $request->except('recipe_image');
                    File::makeDirectory(public_path("/temp_recipe"), 0777, true, true);
                    $step1Value['image_path'] = Storage::putFile('public/temp_recipe', $request->file('recipe_image'));;
                }


                if ($step1Value['scheduled_date']) {
                    $publishTime = new \DateTime($step1Value['scheduled_date']);
                    $publishHour = ($step1Value['scheduled_hour']) ? $step1Value['scheduled_hour'] : 0;
                    $publishMinute = ($step1Value['scheduled_minute']) ? $step1Value['scheduled_minute'] : 0;
                    $publishTime = $publishTime->setTime($publishHour, $publishMinute, 0);
                    $step1Value['publish_at'] = $publishTime->format('Y-m-d H:i:s');
                } else {
                    $step1Value['publish_at'] = null;
                }

                session([$action . '_recipe_step1' => $step1Value]);
                break;
            case '2':
                session([$action . '_recipe_step2' => $request->all()]);
                break;
            case '3':
                session([$action . '_recipe_step3' => $request->all()]);
                break;
        }

        return $this->saveRecipe($request, true);
    }

    public function generateSession($rid = null)
    {
        if ($rid) {
            $stepValue = Recipe::find($rid);
            $recipeChanged = false;
            if(session()->exists('edit_recipe_step1') && $rid != session('edit_recipe_step1')['recipe_id']){
                $recipeChanged = true;
                session()->forget('validation');
            }

            if (!session()->exists('edit_recipe_step1') || $recipeChanged) {
                $step1 = array();
                $step1['recipe_id'] = $rid;
                $step1['recipe_name'] = $stepValue->name;
                $step1['slug'] = $stepValue->slug;
                $step1['recipe_course'] = $stepValue->recipe_course_id;
                $step1['recipe_serves'] = "serves_main";
                $step1['serves_number'] = "";
                $step1['serves_shared_number'] = "";
                if ($stepValue->serves_main && $stepValue->serves_shared) {
                    $step1["recipe_serves"] = "serves_and_shared";
                    $step1['serves_number'] = $stepValue->serves_main;
                    $step1["serves_shared_number"] = $stepValue->serves_shared;
                } else if ($stepValue->serves_main) {
                    $step1["recipe_serves"] = "serves_main";
                    $step1['serves_number'] = $stepValue->serves_main;
                } elseif ($stepValue->serves_shared) {
                    $step1["recipe_serves"] = "serves_shared";
                    $step1['serves_number'] = $stepValue->serves_shared;
                } else if ($stepValue->makes) {
                    $step1["recipe_serves"] = "makes";
                    $step1['serves_number'] = $stepValue->makes;
                }

                $step1['preparation_time'] = $stepValue->preparation_time;
                $step1['cooking_time'] = $stepValue->cooking_time;
                $step1['recipe_image_id'] = $stepValue->image_id;
                $step1['recipe_intro'] = $stepValue->intro;

                foreach ($stepValue->tags as $tag) {
                    $step1['recipe_tags'][] = $tag['id'];
                }

                $step1['recipe_source'] = $stepValue->recipe_source_id;
                $step1['recipe_seo_meta'] = "";
                $step1['active'] = ($stepValue->active) ? "1" : "0";
                $step1['publish_at'] = $stepValue->publish_at;

                session(['edit_recipe_step1' => $step1]);
            }

            if (!session()->exists('edit_recipe_step2') || $recipeChanged) {
                $step2 = array();
                $step2['recipe_id'] = $rid;
                $step2['cals'] = $stepValue->nutrition->cals;
                $step2['protein'] = $stepValue->nutrition->protein;
                $step2['carbs'] = $stepValue->nutrition->carbs;
                $step2['sugars'] = $stepValue->nutrition->sugars;
                $step2['fat'] = $stepValue->nutrition->fat;
                $step2['satfat'] = $stepValue->nutrition->satfat;
                $step2['fibre'] = $stepValue->nutrition->fibre;
                $step2['sodium'] = $stepValue->nutrition->sodium;

                foreach ($stepValue->steps as $key => $step) {
                    $step2['steps'][$key] = $step->instruction;
                }
                session(['edit_recipe_step2' => $step2]);
            }

            if (!session()->exists('edit_recipe_step3') || $recipeChanged) {
                $recipeIngredients = RecipeIngredientSection::where('recipe_id', $rid)->orderBy('id')->get();
                $step3 = array();
                $step3['recipe_id'] = $rid;
                $step3['recipe_section'] = array();

                if (count($recipeIngredients)){
                    $ingredientCount = 0;
                    $ingredientSectionCheck = $recipeIngredients->first()->ingredient_section_id;
                    foreach ($recipeIngredients as $key => $ingredient) {
                        if ($ingredient->ingredient_section_id != $ingredientSectionCheck) {
                            $ingredientCount = 0;
                            $ingredientSectionCheck = $ingredient->ingredient_section_id;
                        }
                        $step3['recipe_section'][$ingredient->ingredient_section_id][$ingredientCount]['recipe_ingredient_id'] = $ingredient->recipe_ingredient_id;
                        $step3['recipe_section'][$ingredient->ingredient_section_id][$ingredientCount]['unit'] = $ingredient->unit;
                        $ingredientCount++;
                    }
                }else{
                    $step3['recipe_section'][1][0]['recipe_ingredient_id'] = "";
                    $step3['recipe_section'][1][0]['unit'] = "";
                    $step3['recipe_section'][1][1]['recipe_ingredient_id'] = "";
                    $step3['recipe_section'][1][1]['unit'] = "";
                    $step3['recipe_section'][1][2]['recipe_ingredient_id'] = "";
                    $step3['recipe_section'][1][2]['unit'] = "";
                }

                session(['edit_recipe_step3' => $step3]);
            }
            session()->forget('create_recipe_step1');
            session()->forget('create_recipe_step2');
            session()->forget('create_recipe_step3');

        } else {
            if (!session()->exists('create_recipe_step1')) {
                $step1 = array();
                $step1['recipe_id'] = "";
                $step1['recipe_name'] = "";
                $step1['slug'] = "";
                $step1['recipe_course'] = '1';
                $step1['recipe_serves'] = "serves_main";
                $step1['serves_number'] = null;
                $step1['serves_shared_number'] = "";
                $step1['preparation_time'] = "";
                $step1['cooking_time'] = "";
                $step1['recipe_image_id'] = "";
                $step1['recipe_intro'] = "";
                $step1['recipe_tags'] = [];
                $step1['recipe_source'] = '0';
                $step1['recipe_seo_meta'] = "";
                $step1['publish_at'] = null;
                $step1['active'] = '0';
                session(['create_recipe_step1' => $step1]);
            }

            if (!session()->exists('create_recipe_step2')) {
                $step2 = array();
                $step2['recipe_id'] = '';
                $step2['cals'] = '';
                $step2['protein'] = '';
                $step2['carbs'] = '';
                $step2['sugars'] = '';
                $step2['fat'] = '';
                $step2['satfat'] = '';
                $step2['fibre'] = '';
                $step2['sodium'] = '';
                $step2['steps'][0] = '';
                $step2['steps'][1] = '';
                $step2['steps'][2] = '';
                session(['create_recipe_step2' => $step2]);
            }

            if (!session()->exists('create_recipe_step3')) {
                $step3 = array();
                $step3['recipe_id'] = '';
                $step3['recipe_section'] = array();
                $step3['recipe_section'][1][0]['recipe_ingredient_id'] = "";
                $step3['recipe_section'][1][0]['unit'] = "";
                $step3['recipe_section'][1][1]['recipe_ingredient_id'] = "";
                $step3['recipe_section'][1][1]['unit'] = "";
                $step3['recipe_section'][1][2]['recipe_ingredient_id'] = "";
                $step3['recipe_section'][1][2]['unit'] = "";
                session(['create_recipe_step3' => $step3]);
            }

            session()->forget('edit_recipe_step1');
            session()->forget('edit_recipe_step2');
            session()->forget('edit_recipe_step3');
        }
    }

    public function routeToStep($step, $create = true, $validation = false)
    {
        if ($create) {
            $step1 = session('create_recipe_step1');
            $step2 = session('create_recipe_step2');
            $step3 = session('create_recipe_step3');
        } else {
            $step1 = session('edit_recipe_step1');
            $step2 = session('edit_recipe_step2');
            $step3 = session('edit_recipe_step3');
        }

        if ($validation) {
            $validator1 = $this->validateStep1($step1);
            $validator2 = $this->validateStep2($step2);
            $validator3 = $this->validateStep3($step3);

            $errorCount[0] = count($validator1->errors()->messages());
            $errorCount[1] = count($validator2->errors()->messages());
            $errorCount[2] = count($validator3->errors()->messages());

            $error1 = $validator1->errors();
            $error2 = $validator2->errors();
            $error3 = $validator3->errors();

//            $errors = [];
//            if ($errorCount[2] > 0) {
//                $step = "step3";
//                $errors = $validator3->errors();
//            }
//            if ($errorCount[1] > 0) {
//                $step = "step2";
//                $errors = $validator2->errors();
//            }
//            if ($errorCount[0] > 0) {
//                $step = "step1";
//                $errors = $validator1->errors();
//            }
        } else {
            $error1 = [];
            $error2 = [];
            $error3 = [];
            $errorCount[0] = 0;
            $errorCount[1] = 0;
            $errorCount[2] = 0;
        }
        switch ($step) {
            case "step2":
                return view('admin.recipe.steps.step2', compact('step', 'step2', 'errorCount'))->withErrors($error2);
                break;
            case "step3":
                $ingredientSections = IngredientSection::all();
                $ingredients = IngredientType::with('recipeIngredients')->get();
                return view('admin.recipe.steps.step3', compact('step', 'ingredientSections', 'ingredients', 'step3', 'errorCount'))->withErrors($error3);
                break;
            case "step1":
            default:
                $step = "step1";
                $recipeCourses = RecipeCourse::all();
                $recipeSources = RecipeSource::all();
                $recipeTags = RecipeTag::all();

                $imageCategories = array("other", "blog", "recipe", "video");
                return view('admin.recipe.steps.step1', compact('step', 'recipeTags', 'imageCategories', 'recipeCourses', 'recipeSources', 'step1', 'errorCount'))->withErrors($error1);
        }
    }

    public function validateStep1($step1)
    {
        if (isset($step1['recipe_id'])) {
            $slugID = ", " . $step1['recipe_id'];
        } else {
            $slugID = "";
        }

        $validator = Validator::make($step1, [
            'recipe_name' => 'required',
            'slug' => 'unique:recipes,slug' . $slugID,
            'recipe_course' => 'required',
            'recipe_serves' => 'required',
            'serves_number' => 'required',
            'preparation_time' => 'required|integer',
            'cooking_time' => 'required|integer',
            'recipe_image' => 'image|mimes:jpeg,png,jpg|max:1024',
            'recipe_intro' => 'required',
            'scheduled_hour' => 'numeric',
            'scheduled_minute' => 'numeric',
        ]);

        $validator->after(function ($validator) use ($step1) {
            if (!$step1['recipe_image_id'] && !$step1['image_path']) {
                $validator->errors()->add('recipe_image', 'Please select or upload an image.');
            }

            if ($step1['recipe_serves'] == "serves_and_shared" && !$step1['serves_shared_number']) {
                $validator->errors()->add('serves_shared_number', 'Please fill in shared.');
            }
        });

        return $validator;
    }

    public function validateStep2($step2)
    {
        $validator = Validator::make($step2, [
            'cals' => 'required|numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'sugars' => 'required|numeric',
            'fat' => 'required|numeric',
            'satfat' => 'required|numeric',
            'fibre' => 'required|numeric',
            'sodium' => 'required|numeric',
            'steps.*' => 'required',
        ]);

        return $validator;
    }

    public function validateStep3($step3)
    {
        $validator = Validator::make($step3, [
            'recipe_section.*.*.*' => 'required',
        ]);

        return $validator;
    }

    public function validateRecipe($create = "create")
    {
        if ($create == "create") {
            $validator1 = $this->validateStep1(session('create_recipe_step1'));
            $validator2 = $this->validateStep2(session('create_recipe_step2'));
            $validator3 = $this->validateStep3(session('create_recipe_step3'));
        } else {
            $validator1 = $this->validateStep1(session('edit_recipe_step1'));
            $validator2 = $this->validateStep2(session('edit_recipe_step2'));
            $validator3 = $this->validateStep3(session('edit_recipe_step3'));
        }


        if ($validator1->fails() || $validator2->fails() || $validator3->fails()) {

            $step = "step1";
            if ($validator3->fails()) {
                $step = "step3";
            }
            if ($validator2->fails()) {
                $step = "step2";
            }
            if ($validator1->fails()) {
                $step = "step1";
            }

            return $step;
        } else {
            return true;
        }
    }

    public function saveRecipe(Request $request, $draft = false)
    {
        if ($request->session()->exists('edit_recipe_step1')) {
            $step1 = $request->session()->get('edit_recipe_step1');
            $step2 = $request->session()->get('edit_recipe_step2');
            $step3 = $request->session()->get('edit_recipe_step3');
        } else {
            $step1 = $request->session()->get('create_recipe_step1');
            $step2 = $request->session()->get('create_recipe_step2');
            $step3 = $request->session()->get('create_recipe_step3');
        }


        DB::transaction(function () use ($request, $step1, $step2, $step3, $draft) {

            if ($step1['recipe_id']) {
                $recipe = Recipe::find($step1['recipe_id']);
            } else {
                $recipe = New Recipe();
            }
            $recipe->tips = 1;
            if (isset($step1['image_path']) && $step1['image_path']) {
                $filename = storage_path("app/" . $step1['image_path']);
                $image_id = Image::newImageToCDN($filename);
                if ($image_id) {
                    $recipe->image_id = $image_id;
                } else {
                    if (!$draft)
                    return back()
                        ->withErrors("Image Upload Failed, please upload again.")
                        ->withInput();
                }
            } else {
                $recipe->image_id = $step1['recipe_image_id'];
            }
            $recipe->recipe_course_id = $step1['recipe_course'];
            $recipe->recipe_source_id = $step1['recipe_source'];
            $recipe->serves_main = NULL;
            $recipe->serves_shared = NULL;
            $recipe->makes = NULL;
            $recipe->active = ($step1['active'] == "1") ? 1 : 0;
            $recipe->draft = $draft;
            switch ($step1['recipe_serves']) {

                case 'serves_and_shared':
                    $recipe->serves_main = ($step1['serves_number'])? $step1['serves_number']: null;
                    $recipe->serves_shared = ($step1['serves_shared_number'])? $step1['serves_shared_number']: null;
                    break;
                case 'serves_main':
                    $recipe->serves_main = ($step1['serves_number'])? $step1['serves_number']: null;
                    break;
                case 'serves_shared':
                    $recipe->serves_shared = ($step1['serves_number'])? $step1['serves_number']: null;
                    break;
                case 'makes':
                    $recipe->makes = ($step1['serves_number'])? $step1['serves_number']: null;
            }

            $recipe->name = $step1['recipe_name'];
            $recipe->slug = $step1['slug'];
            $recipe->intro = $step1['recipe_intro'];
            $recipe->preparation_time =  ($step1['preparation_time'])? $step1['preparation_time']: 0;
            $recipe->cooking_time = ($step1['cooking_time'])? $step1['cooking_time']: 0;
            $recipe->publish_at = $step1['publish_at'];
            $recipe->save();


            if ($step1['recipe_id']) {
                foreach (RecipeStep::where('recipe_id', $recipe->id)->get() as $v) {
                    $v->delete();
                }
            }

            foreach ($step2['steps'] as $key => $step) {
                $newStep = New RecipeStep();
                $newStep->recipe_id = $recipe->id;
                $newStep->step_order = $key;
                $newStep->instruction = $step;
                $newStep->save();
            }

            if (isset($step1['recipe_tags'])) {
                foreach ($step1['recipe_tags'] as $key => $tag) {
                    if (is_numeric($tag)) {
                        $tag_to_db[] = $tag;
                    } else {
                        $new_tag = New RecipeTag();
                        $new_tag->name = $tag;
                        $new_tag->save();
                        $tag_to_db[] = $new_tag->id;
                    }

                }
            } else {
                $tag_to_db = [];
            }

            if ($step1['recipe_id']) {
                $nutrition = Nutrition::where('recipe_id', $step1['recipe_id'])->first();
            } else {
                $nutrition = New Nutrition();
            }

            $nutrition->cals = ($step2['cals']) ? $step2['cals'] : null;
            $nutrition->protein = ($step2['protein']) ? $step2['protein'] : null;
            $nutrition->carbs = ($step2['carbs']) ? $step2['carbs'] : null;
            $nutrition->sugars = ($step2['sugars']) ? $step2['sugars'] : null;
            $nutrition->fat = ($step2['fat']) ? $step2['fat'] : null;
            $nutrition->satfat = ($step2['satfat']) ? $step2['satfat'] : null;
            $nutrition->fibre = ($step2['fibre']) ? $step2['fibre'] : null;
            $nutrition->sodium = ($step2['sodium']) ? $step2['sodium'] : null;
            $nutrition->recipe_id = $recipe->id;
            $nutrition->save();


            $recipe->tags()->sync($tag_to_db);

            if ($step1['recipe_id']) {
                foreach (RecipeIngredientSection::where('recipe_id', $step1['recipe_id'])->get() as $s) {
                    $s->delete();
                }
            }
            foreach ($step3['recipe_section'] as $key => $recipeSection) {
                foreach ($recipeSection as $item => $ingredientItem) {
                    if ($ingredientItem['recipe_ingredient_id']){
                        $ris = New RecipeIngredientSection();
                        $ris->recipe_id = $recipe->id;
                        $ris->recipe_ingredient_id = $ingredientItem['recipe_ingredient_id'];
                        $ris->ingredient_section_id = $key;
                        $ris->unit = $ingredientItem['unit'];
                        $ris->save();
                    }
                }
            }

        }, 3);

        Storage::deleteDirectory("/storage/app/public/temp_recipe");

        session()->forget('validation');

        if ($step1['recipe_id']) {
            $request->session()->forget('edit_recipe_step1');
            $request->session()->forget('edit_recipe_step2');
            $request->session()->forget('edit_recipe_step3');

            return redirect()
                ->route('adminRecipes.index')
                ->with('message', 'Recipe with ID '. $step1['recipe_id'] . ' is edited')
                ->with('status', 'success');
        } else {
            $request->session()->forget('create_recipe_step1');
            $request->session()->forget('create_recipe_step2');
            $request->session()->forget('create_recipe_step3');

            return redirect()
                ->route('adminRecipes.index')
                ->with('message', 'Recipe is created')
                ->with('status', 'success');
        }

    }

}

;