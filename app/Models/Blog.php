<?php

namespace App\Models;

use App\Traits\GlobalSearch;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesSlugsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use UsesSlugsTrait;
    use GlobalSearch;
    use SoftDeletes;
    /*
     * ============================================================================================================================================
     * Settings
     * ============================================================================================================================================
     */
    protected $dates = ['deleted_at'];
    
    /*
     * ============================================================================================================================================
     * Relationships
     * ============================================================================================================================================
     */
    public function category()
    {
        return $this->belongsTo('App\Models\BlogCategory','blog_category_id');
    }
    
    public function tags()
    {
        return $this->belongsToMany('App\Models\BlogTag');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Models\BlogComment');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
    
    
    /*
     * ============================================================================================================================================
     * Mutators
     * ============================================================================================================================================
     */
    public function getImageUrlOldAttribute()
    {

//        if(strpos($this->content,'jpeg') !== false)
//            return substr($this->content,strpos($this->content,'src')+5,strpos($this->content,'jpeg')-strpos($this->content,'src')-1);
//
//        if(strpos($this->content,'png') !== false)
//            return substr($this->content,strpos($this->content,'src')+5,strpos($this->content,'png')-strpos($this->content,'src')-1);
//
//        if(strpos($this->content,'jpg') !== false)
//            return substr($this->content,strpos($this->content,'src')+5,strpos($this->content,'jpg')-strpos($this->content,'src')-1);
//
//        if(strpos($this->content,'gif') !== false)
//            return substr($this->content,strpos($this->content,'src')+5,strpos($this->content,'gif')-strpos($this->content,'src')-1);

        if(strpos($this->content,' alt=') !== false)
            //return substr($this->content,strpos($this->content,'src')+5,strpos($this->content,' dsfsf=')-strpos($this->content,'src')-2);
            return substr($this->content,strpos($this->content,'src')+5);

        return Null;

    }

    public function getBlogContentAttribute(){
        if($this->created_at > '2017-03-15' || $this->id == 633 || $this->id == 634)
            return Markdown::convertToHtml($this->content);
        else
            return strip_tags($this->content);
    }


    
}
