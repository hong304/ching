<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->char('id',8);
            $table->string('name');
            $table->string('sub_dir');
            $table->string('file_name');
            $table->timestamp('last_touch_at')->nullable();
            $table->timestamps();
            // set primary key to ID - there is event listener which will create a 8 char length string
            $table->primary('id');
            $table->unique(['sub_dir', 'file_name']);  // can't have same file exist twice in same directory
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
