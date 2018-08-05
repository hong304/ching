<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterModule extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletter_module';

    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }

    public function text_module()
    {
        return $this->hasOne('App\Models\NewsletterTextModule', 'id', 'module_id');
    }
}
