<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterTextModule extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletter_text_module';

    public function newsletter()
    {
        return $this->belongsTo('App\Models\NewsletterModule');
    }
}
