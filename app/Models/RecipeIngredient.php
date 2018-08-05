<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    /*
     * ============================================================================================================================================
     * Settings
     * ============================================================================================================================================
     */
    
    
    /*
     * ============================================================================================================================================
     * Relationships
     * ============================================================================================================================================
     */
    public function recipes()
    {
        return $this->belongsToMany('App\Models\Recipe','recipe_ingredient_section')->withPivot('unit');
    }

    public function ingredientSections()
    {
        return $this->belongsToMany('App\Models\IngredientSection', 'recipe_ingredient_section')->withPivot('unit');
    }

    public function ingredientType(){
        return $this->belongsTo('App\Models\IngredientType', 'ingredient_type_id');
    }
}
