<?php

namespace App\Models;

use App\Traits\UsesSlugsTrait;
use Illuminate\Database\Eloquent\Model;

class RecipeCourse extends Model
{
    use UsesSlugsTrait;

    /*
     * ============================================================================================================================================
     * Settings
     * ============================================================================================================================================
     */
    // no need time stamps on this
    public $timestamps = false;
    
    /*
     * ============================================================================================================================================
     * Relationships
     * ============================================================================================================================================
     */
    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe');
    }
    
}
