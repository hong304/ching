<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientSection extends Model
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
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\IngredientSection','recipe_ingredient_section')->withPivot('unit');
    }

    public function recipes()
    {
        return $this->belongsToMany('App\Models\Recipe','recipe_ingredient_section')->withPivot('unit','recipe_ingredient_id');
    }
    
}
