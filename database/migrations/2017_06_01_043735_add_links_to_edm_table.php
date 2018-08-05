<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinksToEdmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regular_edm', function (Blueprint $table) {
            $table->string('blog_link')->nullable()->after('blog_title');
            $table->string('recipe_link')->nullable()->after('recipe_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regular_edm', function (Blueprint $table) {
            //
        });
    }
}
