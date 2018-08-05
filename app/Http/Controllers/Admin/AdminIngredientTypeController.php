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

class AdminIngredientTypeController extends Controller
{

    public function showIndex()
    {
        return view('admin.ingredient-type.ingredient-type-list');
    }

    public function ajaxGetIngredientTypeData(Request $request)
    {
        $ingredientType = IngredientType::select('id', 'name','created_at', 'updated_at');

        return Datatables::of($ingredientType)
            ->editColumn('name', function ($ingredientType){
                return ucfirst($ingredientType->name);
            })
            ->addColumn('edit', function ($ingredientType) {
                return '<a href="' . route("adminIngredientType.edit", $ingredientType->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            })
            ->addColumn('delete', function ($ingredientType) {
                $type = IngredientType::with('recipeIngredients')->find($ingredientType->id);
                if (count($type->recipeIngredients) == 0) {
                    return '<a href="javascript:void(0);" onclick="deleteIngredientType(' . $ingredientType->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return "-";
            })
            ->make();
    }

    public function showEditIngredientType(Request $request)
    {
        $ingredientType = IngredientType::with('recipeIngredients')->find($request->id);
        return view('admin.ingredient-type.edit-ingredient-type', compact('ingredientType'));
    }

    public function editIngredientType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $successMessage = "Ingredient Type is created.";
        $ingredientType = new IngredientType();
        if ($request->id) {
            $ingredientType = IngredientType::find($request->id);
            $successMessage = "Ingredient Type is edited.";
        }
        $ingredientType->name = $request->name;
        $ingredientType->save();

        return redirect()
            ->route('adminIngredientType.index')
            ->with('message', $successMessage)
            ->with('status', 'success');
    }

    public function showCreateIngredientType(Request $request)
    {
        return view('admin.ingredient-type.create-ingredient-type');
    }

    public function deleteIngredientType(Request $request)
    {
        $type = IngredientType::with('recipeIngredients')->find($request->id);
        if (count($type->recipeIngredients) == 0) {
            IngredientType::destroy($request->id);
            return redirect()
                ->route('adminIngredientType.index')
                ->with('message', 'Ingredient Type with id ' . $request->id . ' is deleted.')
                ->with(('status'), 'success');

        }

        return redirect()
            ->route('adminIngredientType.index')
            ->withErrors("This ingredients in this type are used in recipe, you cannot delete it.");


    }

}

;