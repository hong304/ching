<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class RegularEdmMail extends Mailable
{
    use Queueable, SerializesModels;
    public $edm;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($edmData)
    {
        $this->edm = $edmData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->edm->subject)->view('emails.regular-edm');
    }
}
