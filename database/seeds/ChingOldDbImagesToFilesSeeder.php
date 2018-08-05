<?php

use Illuminate\Database\Seeder;
use App\Models\Image;
//use Storage;

class ChingOldDbImagesToFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first see app environmenet
        if (app()->environment() !== 'production') {
            $this->convert_db_img_to_files('public', 'images_db/');
            $this->convert_clickandcook_img_to_files('public', 'images_static/');
            $this->convert_old_img_to_files('public', 'images_static/');
        }
        else {
            $this->convert_db_img_to_files('origin', 'images_db/');
            $this->convert_clickandcook_img_to_files('origin', 'images_static/');
            $this->convert_old_img_to_files('origin', 'images_static/');
        }
        
    }
    
    private function convert_db_img_to_files($driver, $directory = '')
    {
        
        $disk = Storage::disk($driver);
        
        // get all old images from old database
        $images = DB::connection('old')->select("SELECT * FROM contentobjects_image WHERE imagetype != ''");
        
        foreach ($images as $image) {
            
            // cycle through all current images
            $ext = substr($image->imagetype, 6);
            if ($ext == 'x-ms-bmp') $ext = 'bmp';
            $file = $image->id . '.' . $ext;
            
            // does file already exist
            if (!$disk->exists($directory . $file)) {
                
                // file does not, lets make it
                $this->command->warn('Image file ' . $file . ' does not exist, creating...');
                $result = $disk->put($directory . $file, $image->imagedata);
                
                if ($result == true) {
                    $img_table = new Image();
                    $img_table->name = $image->imagename;
                    $img_table->sub_dir = trim($directory, '/');
                    $img_table->file_name = $file;
                    $img_table->save();
                    
                    $this->command->info('Image file ' . $file . ' created.');
                }
                else {
                    $this->command->error('Image file ' . $file . ' could NOT be created. Please check laravel log.');
                }
                
            }
            else {
                $this->command->info('Image file ' . $file . ' already exists, skipping...');
                $img_table = new Image();
                $img_table->name = $image->imagename;
                $img_table->sub_dir = trim($directory, '/');
                $img_table->file_name = $file;
                $img_table->save();
            }
            
        }
        
    }
    
    private function convert_clickandcook_img_to_files($driver, $directory = '')
    {
        
        $disk = Storage::disk($driver);
        
        $path = (base_path() . '/public/img/clickandcook/');
        $files = scandir((base_path() . '/public/img/clickandcook'));
        unset($files[0]);
        unset($files[1]);
        
        foreach ($files as $file) {
            
            $old_name = $file;
            $file = md5('cc' .$old_name) . '.jpeg';
            
            // does file already exist
            if (!$disk->exists($directory . $file)) {
                
                // file does not, lets make it
                $this->command->warn('Image file ' . $file . ' does not exist, creating...');
                $result = $disk->put($directory . $file, file_get_contents($path . $old_name));
                
                if ($result == true) {
                    $img_table = new Image();
                    $img_table->name = 'clickandcook/' . $old_name;
                    $img_table->sub_dir = trim($directory, '/');
                    $img_table->file_name = $file;
                    $img_table->save();
                    
                    $this->command->info('Image file ' . $file . ' created.');
                }
                else {
                    $this->command->error('Image file ' . $file . ' could NOT be created. Please check laravel log.');
                }
                
            }
            else {
                $this->command->info('Image file ' . $file . ' already exists, skipping...');
                $img_table = new Image();
                $img_table->name = 'clickandcook/' . $old_name;
                $img_table->sub_dir = trim($directory, '/');
                $img_table->file_name = $file;
                $img_table->save();
            }
            
        }
        
    }
    
    private function convert_old_img_to_files($driver, $directory = '')
    {
        
        $disk = Storage::disk($driver);
        
        $path = (base_path() . '/public/img/');
        $files = scandir((base_path() . '/public/img'));
        unset($files[0]);
        unset($files[1]);
        
        foreach ($files as $file) {
            
            $old_name = $file;
            
            $ext = '';
            if (stripos($old_name, '.jpg')) $ext = '.jpeg';
            if (stripos($old_name, '.jpeg')) $ext = '.jpeg';
            if (stripos($old_name, '.gif')) $ext = '.gif';
            if (stripos($old_name, '.png')) $ext = '.png';
            
            if ($ext != '') {
                
                $file = md5('img' . $old_name) . $ext;
                
                // does file already exist
                if (!$disk->exists($directory . $file)) {
                    
                    // file does not, lets make it
                    $this->command->warn('Image file ' . $file . ' does not exist, creating...');
                    $result = $disk->put($directory . $file, file_get_contents($path . $old_name));
                    
                    if ($result == true) {
                        $img_table = new Image();
                        $img_table->name = $old_name;
                        $img_table->sub_dir = trim($directory, '/');
                        $img_table->file_name = $file;
                        $img_table->save();
                        
                        $this->command->info('Image file ' . $file . ' created.');
                    }
                    else {
                        $this->command->error('Image file ' . $file . ' could NOT be created. Please check laravel log.');
                    }
                    
                }
                else {
                    $this->command->info('Image file ' . $file . ' already exists, skipping...');
                    $img_table = new Image();
                    $img_table->name = $old_name;
                    $img_table->sub_dir = trim($directory, '/');
                    $img_table->file_name = $file;
                    $img_table->save();
                }
            }
        }
        
    }
    
}
