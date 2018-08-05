<?php

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogTag;

class MigrateBlogsSeeder extends Seeder
{
    /**
     * Run the database migrations for old blogs.
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
    
        $old_blogs = DB::connection('old')->select('SELECT * FROM blog ORDER BY id');
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
    
        foreach($old_blogs as $old_blog) {
        
            $blog = new Blog();
            $blog->blog_category_id = $old_blog->blog_category_id;
            $blog->published = $old_blog->blogstatus;
            $blog->title = str_replace('&#39;',"'",htmlspecialchars_decode($old_blog->blogtitle));
            
            $content = str_ireplace('src="../../image/', $path , $old_blog->blogcontent);
            $content = str_ireplace('src="../../img/', 'src="/img/' , $content);
            // now need to find files and add extensions (thanks php array functions)
            $content = str_replace(array_values(array_flip($old_img)), array_values($old_img), $content);
            
            $blog->content = $content;
            $blog->created_at = $old_blog->blogdate;
            $blog->updated_at = $old_blog->blogdate;
            $blog->save();
        
        }
        
        unset($old_blogs);
        unset($old_images);
        unset($old_img);
    
        /*
         * ==================================================================================================================
         * BLogCategory Model
         * ==================================================================================================================
         */
    
        $this->command->info("2. Making Blog categories...");
    
        BlogCategory::create(['name'=>'Food']);
        BlogCategory::create(['name'=>'Inspiration']);
        BlogCategory::create(['name'=>'Fun']);
        BlogCategory::create(['name'=>'Travel']);
        BlogCategory::create(['name'=>'News']);
    
        /*
         * ==================================================================================================================
         * BlogComment Model
         * ==================================================================================================================
         */
    
        $this->command->info("3. Migrating BlogComment Models...");
    
        $old_comments = DB::connection('old')->select('SELECT * FROM blog_comment');
        
        foreach ($old_comments as $old_comment)
        {
            BlogComment::create([
               'blog_id'=>$old_comment->blog_id,
               'user_id'=>$old_comment->user_id,
               'comment'=>$old_comment->comment,
               'created_at'=>$old_comment->time,
               'updated_at'=>$old_comment->time,
            ]);
        }
        
        unset($old_comments);
    
        /*
         * ==================================================================================================================
         * BlogTag Models
         * ==================================================================================================================
         */
    
        $this->command->info("4. Reattaching BlogTag to Blog models...");
    
        $pivot = DB::connection('old')->select('SELECT * FROM blog_tags');
        $tags = DB::connection('old')->select('SELECT * FROM tags ORDER BY tid');
    
        foreach ($tags as $tag)
        {
            BlogTag::create(['name'=>strtolower($tag->tags)]);
        }
        
        foreach ($pivot as $item)
        {
            $blog = Blog::find($item->blog_id);
            $blog->tags()->attach($item->tags_id);
            $blog->save();
        }
        
    }
}
