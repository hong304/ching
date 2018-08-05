<?php

namespace App\Models;

use App\Traits\GlobalSearch;
use App\Traits\UsesSlugsTrait;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
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
    public function category()
    {
        return $this->belongsTo('App\Models\VideoCategory', 'video_category_id');
    }
    
    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe');
    }

    public function recipe()
    {
        return $this->hasOne('App\Models\Recipe')->orderBy('updated_at','desc');
    }
    
    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
    /*
     * ============================================================================================================================================
     * Custom getters / setters
     * ============================================================================================================================================
     */
    
    // get the url of the video on CDN
    public function url($video = false, $type = 'hls', $count = true) {
        
        if ($video == false) $video = $this;
        
        if ($count)
        {
            // increment video view counter
            $this->views = $this->views + 1;
            $this->save();
        }
    
        if ($type == 'http') {
            if (request()->secure())
            {
                return config('cdn.https') . '/store/video/' . str_replace('.mp4','',$video->file) . '/'. $video->file;
            }
            else
            {
                return config('cdn.http') . '/store/video/' . str_replace('.mp4','',$video->file) . '/'. $video->file;
            }
        }
        elseif ($type == 'hls')
        {
            return config('cdn.https') . '/store/video/' . str_replace('.mp4','',$video->file) . '/'. 'main.m3u8';
        }
        
        return '';
        
    }
    
    /*
     * ============================================================================================================================================
     * STATIC HELPERS BELOW (useful in views)
     * ============================================================================================================================================
     */
    
    // convenience for views mostly without having to load the video model
    static public function videoUrl($video_id, $type = 'hls', $count = true) {
        
        if ($video = Video::find($video_id)) {
            return $video->url($video, $type, $count);
        } else {
            return 'video_not_found'; // TODO send back a URL of a placeholder non-found video
        }
        
    }

    public function getSearchTitle($keyword)
    {

        $org_keyword = $keyword;

        foreach ($keyword as &$value) {
            $value = '<strong>'.$value.'</strong>';
        }

        return str_ireplace($org_keyword, $keyword, $this->title);
    }

    static public function iso8601_duration($seconds){
        $hours = floor($seconds / 3600);
        $seconds = $seconds % 3600;

        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;

        if ($hours >0){
            return sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds);
        }else{
            return sprintf('PT%dM%dS',$minutes, $seconds);
        }
    }
}
