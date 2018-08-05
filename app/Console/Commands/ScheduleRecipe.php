<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use App\Models\Video;
use Illuminate\Console\Command;

class ScheduleRecipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ching:schedule-recipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule for publishing recipes';

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
        $recipes = Recipe::whereNotNull('publish_at')->where('publish_at', '<', new \DateTime())->where('draft', false)->get();

        foreach ($recipes as $recipe) {
            $recipe->active = true;
            $recipe->publish_at = null;
            $recipe->save();

          Video::where('id', $recipe->video_id)->update(['active' => 1]);

        }
    }
}
