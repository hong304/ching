<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;

class RecipeSource extends Model
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
        return $this->hasMany('App\Models\Recipe');
    }
    
    /*
     * ============================================================================================================================================
     * STATIC HELPERS BELOW (useful in views)
     * ============================================================================================================================================
     */
    
    public function getLink($btn = false)
    {
        if (Session::has('geoData') && ($this->url != '' || $this->url_us != '' || $this->url_au != ''))
        {
            // for now UK Amazon is default
            $link = $this->url;
            $geo = Session::get('geoData');
            
            // if continent is North America (NA) give them Amazon USA link
            if ($geo['country_data']['continent']['code'] == 'NA') $link = $this->url_us;
            
            // need to find Australian / Asian book seller who offers commission!
            if ($btn == true) {
                $link = str_replace('<a ','<a class="button-in-light text-uppercase mt24"',str_replace('##name##','Buy now',$link));
            } else {
                $link = str_replace('##name##',e($this->name),$link) . ' <i class="fa fa-external-link" style="color: #00958F;" aria-hidden="true"></i>';
            }
        }
        else
        {
            $link = e($this->name);
        }
        
        return $link;
    }
}
