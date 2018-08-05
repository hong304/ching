<?php

namespace App\Console;

use App\Console\Commands\ActivationReminder;
use App\Console\Commands\ScheduleBlog;
use App\Console\Commands\ScheduleNewsletter;
use App\Console\Commands\ScheduleRecipe;
use App\Console\Commands\UpdateImageDimensions;
use App\Console\Commands\WriteImageLastTouches;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        WriteImageLastTouches::class,
        UpdateImageDimensions::class,
        ScheduleBlog::class,
        ScheduleRecipe::class,
        ScheduleNewsletter::class,
        ActivationReminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('ching:write-image-last-touches')
                 ->everyMinute();

        $schedule->command('ching:schedule-blog')
            ->everyMinute();

        $schedule->command('ching:schedule-recipe')
            ->everyMinute();

        $schedule->command('ching:schedule-newsletter')
            ->everyMinute();

        $schedule->command('ching:activation-reminder')
            ->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
