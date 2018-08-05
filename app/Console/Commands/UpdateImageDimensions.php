<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;

class UpdateImageDimensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ching:update-images-dimensions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Go through all images and update their height and width in DB';

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
        //
        foreach (Image::get() as $image)
        {
            $url = str_replace('https:','http:',$image->url());
            $this->info($url);
            $data = getimagesize($url);
            $image->width = $data[0];
            $image->height = $data[1];
            $image->save();
            $this->info($image->id . ' update to '.$data[0] .'x' .$data[1]);
        }

        return true;
    }
}
