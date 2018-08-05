<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use MaxMind\Db\Reader;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        /*
         * This is where all our event listeners go for now, eventually we'll move to their own file
         */



        $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '223.197.178.136';

        if(config('app.env')=='local')
            $ipAddress = '223.197.178.136';

      //  $euip = '88.159.229.168';

        $databaseFile = storage_path('geolite/GeoLite2-City.mmdb');
        $reader = new Reader($databaseFile);
        $geoData = $reader->get($ipAddress);
        $reader->close();

        $geoCode = "HK";
        if( is_array($geoData) && isset($geoData['country']) && isset($geoData['country']['iso_code']) ){
            $geoCode = $geoData['country']['iso_code'];
        }

        if(!Session::has('geoData')){
            $result['country_data'] = $geoData;
            $result['ipaddress'] = $ipAddress;
            Session::put('geoData',$result);
        }

        $currentCountry = Country::where('iso_3166_2', $geoCode)->first();

        //pass country list to all view
        if (Cache::has('countries_for_view'))
        {
            $countries = Cache::get('countries_for_view');
        }
        else
        {
            $countries = Country::getCountriesListWithFlag();
            // put in cache for 2 hours
            Cache::put('countries_for_view', $countries, 120);
        }

        \View::composer('*', function($view) use($countries,$currentCountry,$geoData)
        {
            $view->with('countries', $countries);
            $view->with('currentCountry', $currentCountry);
            $view->with('continent',(isset($geoData['continent']['code']))? $geoData['continent']['code']: "" );
        });

        // Make a unique ID string based on Images table
        Image::creating(function ($image) {
            $image->id = str_random(8);
            return true;
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register ide helper only on non-production systems
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
