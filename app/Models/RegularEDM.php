<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegularEDM extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regular_edm';

    public function blogImage()
    {
        return $this->belongsTo('App\Models\Image', 'blog_image_id');
    }

    public function instagramImage1()
    {
        return $this->belongsTo('App\Models\Image', 'instagram_image_id_1');
    }
    public function instagramImage2()
    {
        return $this->belongsTo('App\Models\Image', 'instagram_image_id_2');
    }
    public function instagramImage3()
    {
        return $this->belongsTo('App\Models\Image', 'instagram_image_id_3');
    }
    public function instagramImage4()
    {
        return $this->belongsTo('App\Models\Image', 'instagram_image_id_4');
    }

    public function recipeImage()
    {
        return $this->belongsTo('App\Models\Image', 'recipe_image_id');
    }

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'regular_edm_user', 'edm_id');
    }
}
