<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\IngredientSection;
use App\Models\IngredientType;
use App\Models\RecipeIngredient;
use App\Models\RecipeIngredientSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminIngredientController extends Controller
{

    public function showIndex()
    {
        return view('admin.ingredient.ingredient-list');
    }

    public function ajaxGetIngredientData(Request $request)
    {
        $ingredients = RecipeIngredient::leftJoin('ingredient_types', 'ingredient_types.id', '=', 'recipe_ingredients.ingredient_type_id')->select('recipe_ingredients.id', 'recipe_ingredients.name as name','ingredient_types.name as type' ,'recipe_ingredients.created_at', 'recipe_ingredients.updated_at');

        return Datatables::of($ingredients)
            ->editColumn('type', function ($ingredients){
                return ucfirst($ingredients->type);
            })
            ->addColumn('edit', function ($ingredients) {
                return '<a href="' . route("adminIngredients.edit", $ingredients->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            })
            ->addColumn('delete', function ($ingredients) {
                if (!RecipeIngredientSection::where('recipe_ingredient_id', "=", $ingredients->id)->exists()) {
                    return '<a href="javascript:void(0);" onclick="deleteIngredient(' . $ingredients->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return "-";
            })
            ->make(true);
    }

    public function showEditIngredient(Request $request)
    {
        $ingredient = RecipeIngredient::with('ingredientType')->find($request->id);
        $ingredientType = IngredientType::all();
        return view('admin.ingredient.edit-ingredient', compact('ingredient', 'ingredientType'));
    }

    public function editIngredient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ingredient_type' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $successMessage = "Ingredient is created.";
        $ingredient = new RecipeIngredient();
        if ($request->id) {
            $ingredient = RecipeIngredient::find($request->id);
            $successMessage = "Ingredient is edited.";
        }
        $ingredient->name = $request->name;
        $ingredient->ingredient_type_id = $request->ingredient_type;
        $ingredient->save();

        return redirect()
            ->route('adminIngredients.index')
            ->with('message', $successMessage)
            ->with('status', 'success');
    }

    public function showCreateIngredient(Request $request)
    {
        $ingredientType = IngredientType::all();
        return view('admin.ingredient.create-ingredient', compact('ingredientType'));
    }

    public function deleteIngredient(Request $request)
    {
        if (!RecipeIngredientSection::where('recipe_ingredient_id', "=", $request->id)->exists()){
            RecipeIngredient::destroy($request->id);
            return redirect()
                ->route('adminIngredients.index')
                ->with('message', 'Ingredient with id ' . $request->id . ' is deleted.')
                ->with(('status'), 'success');
        }

        return redirect()
            ->route('adminIngredients.index')
            ->withErrors("This ingredient section is used in recipe, you cannot delete it.");


    }

}

;