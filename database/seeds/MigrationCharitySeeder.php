<?php

use Illuminate\Database\Seeder;

class MigrationCharitySeeder extends Seeder
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
  * Blog Model
  * ==================================================================================================================
  */

        $this->command->info("1. Migrating Blogs tables...");

        $old_charitys = DB::connection('old')->select('SELECT * FROM charity ORDER BY id');
        $old_images = DB::connection('old')->select('SELECT id,imagetype FROM contentobjects_image');

        // if local make image file links for local machine, if production, make for rackspace CDN
        if (app()->environment() !== 'production') {
            $path = 'src="/storage/images_db/';
        } else {
            $path = 'src="'. config('cdn.https') . '/img/medium/';
        }

        // add file extensions, make an array to replace all the image names in the old blog entries
        $old_img = [];
        foreach ($old_images as $img) {
            $old_img[$img->id] = $img->id;
            switch ($img->imagetype)
            {
                case 'image/jpeg':
                    $old_img[$img->id] .= '.jpeg';
                    break;
                case 'image/gif':
                    $old_img[$img->id] .= '.gif';
                    break;
                case 'x-ms-bmp':
                    $old_img[$img->id] .= '.bmp';
                    break;
                default:
                    $old_img[$img->id] .= '';
            }
        }

        $blog_category = New \App\Models\BlogCategory();
        $blog_category->name = 'Charity';
        $blog_category->save();

        foreach($old_charitys as $old_blog) {

            $blog = new \App\Models\Blog();
            $blog->blog_category_id = $blog_category->id;
            $blog->published = $old_blog->charitystatus;
            $blog->title = str_replace('&#39;',"'",htmlspecialchars_decode($old_blog->charitytitle));

            $content = str_ireplace('src="../../image/', $path , $old_blog->charitycontent);
            $content = str_ireplace('src="../../img/', 'src="/img/' , $content);
            // now need to find files and add extensions (thanks php array functions)
            $content = str_replace(array_values(array_flip($old_img)), array_values($old_img), $content);

            $blog->content = $content;
            $blog->created_at = $old_blog->charitydate;
            $blog->updated_at = $old_blog->charitydate;
            $blog->save();

        }
    }
}
