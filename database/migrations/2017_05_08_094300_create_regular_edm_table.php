<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegularEdmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regular_edm', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();

            $table->text('header_content')->nullable();

            $table->string('blog_title')->nullable();
            $table->string('blog_image_id')->nullable();
            $table->string('blog_image_alt')->nullable();
            $table->timestamp('blog_date')->nullable();
            $table->text('blog_intro')->nullable();

            $table->string('instagram_link_1')->nullable();
            $table->string('instagram_image_id_1')->nullable();
            $table->string('instagram_image_alt_1')->nullable();
            $table->string('instagram_link_2')->nullable();
            $table->string('instagram_image_id_2')->nullable();
            $table->string('instagram_image_alt_2')->nullable();
            $table->string('instagram_link_3')->nullable();
            $table->string('instagram_image_id_3')->nullable();
            $table->string('instagram_image_alt_3')->nullable();
            $table->string('instagram_link_4')->nullable();
            $table->string('instagram_image_id_4')->nullable();
            $table->string('instagram_image_alt_4')->nullable();

            $table->string('recipe_title')->nullable();
            $table->string('recipe_image_id')->nullable();
            $table->string('recipe_image_alt')->nullable();
            $table->text('recipe_intro')->nullable();

            $table->integer('no_of_sent')->default(0);

            $table->timestamp('send_time')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regular_edm');
    }
}
