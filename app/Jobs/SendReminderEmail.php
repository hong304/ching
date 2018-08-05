<?php

namespace App\Jobs;

use App\Mail\newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use Log;

class SendReminderEmail implements ShouldQueue
{
    public $i3d;
    public $s3key;

    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->i3d = $data['id'];
        $this->s3key = $data['s3key'];

    }
    /**
     * Execute the job.
     *
     * @param
     * @return void
     */

    public function handle() {
        usleep(rand(10000,100000));
        Log::info('Hello! Queue job '.$this->i3d.' is run at start time - '.microtime(true));
    }
}
