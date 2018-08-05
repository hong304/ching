<?php

namespace App\Models;

use App\Traits\GlobalSearch;
use App\Traits\UsesSlugsTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use UsesSlugsTrait;
    use GlobalSearch;

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
    public function steps()
    {
        return $this->hasMany('App\Models\RecipeStep');
    }

    public function recipe_course()
    {
        return $this->belongsTo('App\Models\RecipeCourse');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\RecipeTag');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function video()
    {
        return $this->belongsTo('App\Models\Video');
    }

    public function nutrition()
    {
        return $this->hasOne('App\Models\Nutrition');
    }

    public function ingredients()
    {
        return $this->belongsToMany('App\Models\RecipeIngredient', 'recipe_ingredient_section')->withPivot('unit');
    }

    public function sections()
    {
        return $this->belongsToMany('App\Models\IngredientSection', 'recipe_ingredient_section')->withPivot('unit', 'recipe_ingredient_id');
    }

    public function source()
    {
        return $this->belongsTo('App\Models\RecipeSource', 'recipe_source_id');
    }


//    public function tagRelation()
//    {
//       return $this->belongsToMany('App\Models\RecipeTag')
//           // ->select(\DB::raw('count(*) as recipe_tag_id'))
//                    ->selectRaw('count(*) as count')
//                    ->groupBy('pivot_recipe_tag_id');
//    }

//    public function counts(){
//        return $this->belongsToMany('App\Models\RecipeTag')
//            ->selectRaw('count(recipe_recipe_tag.recipe_tag_id) as pivot_count')
//            ->groupBy('pivot_recipe_tag_id');
//    }


    /*
     * ============================================================================================================================================
     * Mutators
     * ============================================================================================================================================
     */
    public function getNameAttribute($value)
    {
        return title_case($value);
    }

    public function getIntroContentAttribute()
    {
        if ($this->created_at > '2017-03-15') {
            return Markdown::convertToHtml($this->intro);
        } else {
            if (strpos($this->intro, '*Serves') > 0)
                return substr($this->intro, 0, strpos($this->intro, '*Serves'));
            elseif (strpos($this->intro, 'Serves') > 0)
                return substr($this->intro, 0, strpos($this->intro, 'Serves'));
            else
                return $this->intro;
        }
    }


}
