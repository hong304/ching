<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;

class ScheduleBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ching:schedule-blog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler for publishing Blog post';

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
        $blog = Blog::whereNotNull('publish_at')->where('publish_at', '<', new \DateTime())->get();

        foreach ($blog as $b){
            $b->published = true;
            $b->publish_at = null;
            $b->save();
        }
    }
}
