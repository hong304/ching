<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Don't use the shitty WebPaster model, it loads from JSON for no good reason.

class Country extends Model
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
    
    // should belong to user???
    
    
    
    public static function getFlagFromId($id, $squared = false)
    {

        $country = Country::find($id);
        //return $country;
        return '<span class="flag-icon flag-icon-'. strtolower($country->iso_3166_2) . ($squared ? ' flag-icon-squared' : '') . '"></span>';

    }

    public static function getCountriesListWithFlag($squared = false){
        $countries = Country::orderBy('name')->get();;

        foreach ($countries as $country){
//            $country->flag_icon = '<span class="flag-icon flag-icon-'. strtolower($country->iso_3166_2) . ($squared ? ' flag-icon-squared' : '') . '"></span>';
            $country->flag_icon = "flag-icon flag-icon-". strtolower($country->iso_3166_2) . ($squared ? ' flag-icon-squared' : '');
        }
//        dd($countries->toArray());
        return $countries->toArray();
    }
}
