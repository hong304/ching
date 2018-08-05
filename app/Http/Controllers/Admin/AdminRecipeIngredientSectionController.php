<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\IngredientSection;
use App\Models\RecipeIngredientSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminRecipeIngredientSectionController extends Controller
{

    public function showIndex()
    {
        return view('admin.recipe-ingredient-section.section-list');
    }

    public function ajaxGetIngredientSectionData(Request $request)
    {
        $ingredientSection = IngredientSection::select(['id', 'name', 'created_at', 'updated_at'])->orderBy('id', 'desc');
        return Datatables::of($ingredientSection)
            ->addColumn('edit', function ($ingredientSection) {
                return '<a href="' . route("adminRecipeIngredientSection.edit", $ingredientSection->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            })
            ->addColumn('delete', function ($ingredientSection) {
                if (!RecipeIngredientSection::where('ingredient_section_id', "=", $ingredientSection->id)->exists()) {
                    return '<a href="javascript:void(0);" onclick="deleteIngredientSection(' . $ingredientSection->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return "-";
            })
            ->make();
    }

    public function showEditIngredientSection(Request $request)
    {
        $ingredientSection = IngredientSection::find($request->id);
        return view('admin.recipe-ingredient-section.edit-section', compact('ingredientSection'));
    }

    public function editIngredientSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $successMessage = "Ingredient Section is created.";
        $ingredientSection = new IngredientSection();
        if ($request->id) {
            $ingredientSection = IngredientSection::find($request->id);
            $successMessage = "Ingredient Section is edited.";
        }
        $ingredientSection->name = $request->name;
        $ingredientSection->save();

        return redirect()
            ->route('adminRecipeIngredientSection.index')
            ->with('message', $successMessage)
            ->with('status', 'success');
    }

    public function showCreateIngredientSection(Request $request)
    {
        return view('admin.recipe-ingredient-section.create-section');
    }
    public function deleteIngredientSection(Request $request)
    {
        if (!RecipeIngredientSection::where('ingredient_section_id', "=", $request->id)->exists()){
            IngredientSection::destroy($request->id);
            return redirect()
                ->route('adminRecipeIngredientSection.index')
                ->with('message', 'Ingredient Section with id ' . $request->id . ' is deleted.')
                ->with(('status'), 'success');
        }

        return redirect()
            ->route('adminRecipeIngredientSection.index')
            ->withErrors("This ingredient section is used in recipe, you cannot delete it.");


    }

}

;