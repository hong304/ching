<?php

namespace App\Console\Commands;

use App\Models\ActivationKey;
use App\Models\User;
use App\Notifications\RemindActivationNotification;
use App\Traits\ActivationKeyTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ActivationReminder extends Command
{
//    use ActivationKeyTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ching:activation-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to User who forget to activate by 3 days';

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
        $activations = ActivationKey::where('reminder', false)->whereNull('activation_time')->whereDate('created_at', '<', Carbon::now()->subDay(3))->get();

        foreach ($activations as $activation ){
            $user = User::where('id', $activation->user_id)->first();
            if (!$user->activated){
                $user->notify(new RemindActivationNotification($activation,$user));
                $activation->reminder = true;
                $activation->save();
            }
        }
    }
}
