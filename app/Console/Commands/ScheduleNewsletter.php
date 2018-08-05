<?php

namespace App\Console\Commands;

use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Console\Command;

class ScheduleNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ching:schedule-newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler for sending Newsletter out';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newsletters = Newsletter::whereNotNull('send_time')->where('send_time', '<', new \DateTime())->get();

        foreach ($newsletters as $newsletter){
            $newsletter->no_of_sent = $newsletter->no_of_sent+1;
            $newsletter->send_time = null;
            $newsletter->save();
            User::select('id', 'email')->where('activated', true)->chunk(1000, function ($emailList) use ($newsletter) {

                foreach ($emailList as $email) {
                    $newsletter->userId = $email['id'];
                    $message = (new NewsletterMail($newsletter))->onConnection('database')->onQueue('emails');
                    \Mail::bcc($email['email'])
                        ->queue($message);
                }
            });
        }

    }
}
