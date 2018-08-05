<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeImageToImageIdOnBlogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('image', 'image_id');
        });

        foreach (\App\Models\Blog::get() as $blog)
        {

            //var_dump($blog);

            if ($blog->image_url_old) {
                $file = str_replace('https://cdn.chinghehuang.com/img/medium/', '', $blog->image_url_old);
                $file = str_replace('/storage/images_db/', '', $file);
                $file = str_replace('/storage/images_static/', '', $file);
                $file = str_replace('/img/', '', $file);
                $file = str_replace('"', '', $file);
                if (strpos($file,'>'))
                {
                    $file = substr($file,0,stripos($file,' alt'));
                }

                if (stripos($file,'.')) {
                    $file = substr($file,0,stripos($file,'.'));
                }

                $img = \App\Models\Image::where('file_name','LIKE',$file .'%')->orWhere('name', 'LIKE',$file.'%')->first();

                //echo $blog->id . " - " . $file . ' -> ' . $img->id  . PHP_EOL;


                if ($img) {
                    echo $blog->id . " - " . $file . ' -> ' . $img->id  . PHP_EOL;
                    $blog->image_id = $img->id;
                    $blog->save();
                }

            }

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('image_id', 'image');
        });
    }
}
