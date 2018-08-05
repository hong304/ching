<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Cache;

class WriteImageLastTouches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ching:write-image-last-touches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Writes all the last touch times to images from cache (and flushes the cache)';

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
        // see if anything to write
        if (Cache::has('image_touches'))
        {
            $imgs = Cache::get('image_touches');
            // immediate forget so start fresh collecting
            Cache::forget('image_touches');
    
            foreach ($imgs as $id => $time)
            {
                if ($image = Image::find($id))
                {
                    $time = date('Y-m-d H:i:s', $time);
                    $image->last_touch_at = $time;
                    $image->save();
                    $this->info('Image '.$id.' touched at '.$time);
                }
            }
            
        }
        return true;
    }
}
