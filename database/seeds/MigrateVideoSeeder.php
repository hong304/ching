<?php

use Illuminate\Database\Seeder;
use \App\Models\VideoCategory;
use \App\Models\Video;
use \App\Models\Image;

class MigrateVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * ==================================================================================================================
         * first make video Categories
         * ==================================================================================================================
         */
    
        ini_set('max_execution_time',0);
        ini_set('memory_limit',1073741824);
        
        $this->command->info("1. Migrating Video Categories...");

        //DB::table('video_categories')->delete();

        $cat = new VideoCategory();
        $cat->name = 'Click and Cook';
        $cat->description = 'Ching\'s Easy-to-Follow recipe videos designed to help you cook your favourite Chinese and Asian fusion recipes.';
        $cat->active = 1;
        $cat->save();
    
        $cat = new VideoCategory();
        $cat->name = 'Hot off the Wok';
        $cat->description = 'Lee Kum Kee challenges Ching in this exclusive online series to find the 10 of the coolest chefs in foodie destination Hong Kong.';
        $cat->active = 1;
        $cat->save();
    
        $cat = new VideoCategory();
        $cat->name = 'Lee Kum Kee Shorts';
        $cat->description = 'Ching shows you her favourite ways to cook with Chinese-style sauces from sauce specialists Lee Kum Kee.';
        $cat->active = 1;
        $cat->save();
    
        $cat = new VideoCategory();
        $cat->name = 'Travel';
        $cat->description = '';
        $cat->active = 0;
        $cat->save();
    
        /*
         * ==================================================================================================================
         * Now move Click and Cook videos
         * ==================================================================================================================
         */
    
        DB::table('videos')->truncate();
    
        $this->command->info("2. Adding Click and Cook videos...");
    
        $old_videos = DB::connection('old')->select('SELECT * FROM clickandcook ORDER BY `ID`');
        
        //DB::table('videos')->delete();

        foreach ($old_videos as $old_video)
        {
    
            $this->command->info("Adding video ".$old_video->Recipe_url."...");
    
            $new_file_name = strtolower(substr(md5($old_video->Recipe_url),0,10)) . '.mp4';
            
            if (Video::where('file',$new_file_name)->count() == 0) {
                
                $vid = new Video();
                $vid->file = $new_file_name;
                $vid->name = $old_video->Recipe_name;
                $vid->video_category_id = 1;
                $vid->release_date = '2017-01-01';
    
                $img = Image::where('name', 'clickandcook/' . $old_video->Recipe_poster)->first();
                $vid->image_id = $img->id;
    
                $disk = Storage::disk('origin');
    
                if ($disk->exists('video/' . str_replace('.mp4','',$vid->file) . '/' . $vid->file)) {
                    $this->command->warn("Video already CDN copied, skipping...");
                }
                else {
                    $this->command->warn("Videos already done, but seems to be a missing one...");
                    //$disk->put('stream/queue/' . $vid->file, file_get_contents('http://2d10919716b32e9df3cb-a43ca805f4ded85897c1c0b24c434556.r74.cf2.rackcdn.com/' . str_replace(' ','%20',$old_video->Recipe_url) . '.f4v'));
                }
    
                $vid->save();

                $recipe = \App\Models\Recipe::find($old_video->Recipe_id);
                $recipe->video_id = $vid->id;
                $recipe->save();
                
            }
            else
            {
                $this->command->warn("Video already created, skipping...");
            }
        }
    
        unset($old_videos);
        unset($disk);
    
        /*
         * ==================================================================================================================
         * Now move Hot off the Wok videos
         * ==================================================================================================================
         */
    
        $this->command->info("3. Adding Hot off the Wok videos...");
        
        $local = Storage::disk('public');
        $origin = Storage::disk('origin');
    
        $files = $local->allFiles('video/hotw');
        $files = array_filter($files, function($var) { if (strpos($var,'.mp4')) return true; else return false; });
        
        
    
        foreach ($files as $file)
        {
    
            $this->command->info("Video already created, skipping...");
    
            $file = str_replace('video/hotw/','',$file);
            $new_file_name = strtolower(substr(md5($file),0,10)) . '.mp4';
        
            if (Video::where('file',$new_file_name)->count() == 0) {
            
                $vid = new Video();
                $vid->file = $new_file_name;
                $vid->name = str_replace('_',' ',str_replace('.mp4','',$file));
                $vid->video_category_id = 2;
                $vid->release_date = '2017-01-01';
            
                $img = Image::where('name', str_replace('.mp4','.jpeg',$file))->first();
                $vid->image_id = $img->id;
            
            
                if ($origin->exists('video/' . str_replace('.mp4','',$vid->file) . '/' . $vid->file)) {
                    $this->command->info("Video already on CDN, skipping...");
                }
                else {
                    $this->command->warn("Video seems to be missing! check...");
                    //$origin->put('stream/queue/' .$vid->file, $local->get('public/video/hotw/'.$file));
                }
    
                $vid->save();
                
            }
            else
            {
                $this->command->info("Video already created, skipping...");
            }
        }
    
        /*
         * ==================================================================================================================
         * Now move LKK videos
         * ==================================================================================================================
         */
    
        $this->command->info("4. Adding LKK videos...");
    
        $local = Storage::disk('public');
        $origin = Storage::disk('origin');
        
        $files = $local->allFiles('video/lkk');
        $files = array_filter($files, function($var) { if (strpos($var,'.mp4')) return true; else return false; });
    
        ini_set('max_execution_time',0);
    
        foreach ($files as $file)
        {
        
            $file = str_replace('video/lkk/','',$file);
            $new_file_name = strtolower(substr(md5($file),0,10)) . '.mp4';
        
            if (Video::where('file',$new_file_name)->count() == 0) {
            
                $vid = new Video();
                $vid->file = $new_file_name;
                $vid->name = str_replace('_',' ',str_replace('.mp4','',$file));
                $vid->video_category_id = 3;
                $vid->release_date = '2017-01-01';
            
                $this->command->info(str_replace('.mp4','.jpeg',$file));
                $img = Image::where('name', str_replace('.mp4','.jpeg',$file))->first();
                $vid->image_id = $img->id;
    
    
                if ($origin->exists('video/' . str_replace('.mp4','',$vid->file) . '/' . $vid->file)) {
                    $this->command->info("Video already on CDN, skipping...");
                }
                else {
                    $this->command->warn("Video seems to be missing! check...");
                    //$origin->put('stream/queue/' .$vid->file, $local->get('public/video/hotw/'.$file));
                }
            
                $vid->save();
            
            }
            else
            {
                $this->command->info("Video already created, skipping...");
            }
        }
        
    
    
        /*// Just import the Video's table from CSV file now!
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }
        
        $csv = \League\Csv\Reader::createFromPath(storage_path().'/'.'videos.csv');
        $arr = $csv->fetchAssoc();
        foreach ($arr as $ar)
        {
            DB::table('videos')->insert( $ar );
        }*/
        
        // fix video ID
        $videos = Video::where('id','>',52)->get();
        
        foreach ($videos as $video)
        {
            if ($i = Image::where('name','LIKE',str_replace(' ','_',$video->name).'%')->first())
            {
                $this->command->info('Updated image_id for video '.$video->name);
                $video->image_id = $i->id;
                $video->save();
            }
        }
        
    
    }
    
    
}
