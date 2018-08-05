<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletter';

    public function cover_image()
    {
        return $this->belongsTo('App\Models\Image', 'cover_image_id');
    }

    public function newsletter_module(){
        return $this->hasMany(NewsletterModule::class);
    }

    public function user()
    {
        return $this->belongsToMany('App\Models\NewsletterUser', 'newsletter_user', 'newsletter_id');
    }
}
