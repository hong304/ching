<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->boolean('active')->default(0);
            $table->integer('recipe_course_id', false, true);
            $table->integer('video_id', false, true)->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->char('image_id',8)->nullable();
            $table->tinyInteger('serves_main',false,true)->nullable();
            $table->tinyInteger('serves_shared',false,true)->nullable();
            $table->string('makes',false,true)->nullable();
            $table->text('intro');
            $table->text('tips');
            $table->smallInteger('preparation_time',false,true)->default(0);
            $table->smallInteger('cooking_time',false,true)->default(0);
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
        Schema::dropIfExists('recipes');
    }
}
