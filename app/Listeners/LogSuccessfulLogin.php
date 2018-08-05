<?php

namespace App\Listeners;

use App\Http\Controllers\Auth\LoginController;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param  SluggableSaved  $event
     * @return void
     */
    public function handle(\Illuminate\Auth\Events\Login $event)
    {
        LoginController::recordAuditLogin();
    }
}
