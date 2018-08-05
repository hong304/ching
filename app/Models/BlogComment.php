<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class BlogComment extends Model
{
    use SoftDeletes;
    use Notifiable;

    /*
     * ============================================================================================================================================
     * Settings
     * ============================================================================================================================================
     */
    protected $fillable = ['blog_id','user_id','comment','created_at','updated_at'];
    
    /*
     * ============================================================================================================================================
     * Relationships
     * ============================================================================================================================================
     */
    public function blog()
    {
        return $this->belongsTo('App\Models\Blog');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function routeNotificationForSlack() {
        return env('SLACK_WEBHOOK_COMMENT_URL');
    }

}
