<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRecipeSourceUrlsToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipe_sources', function (Blueprint $table) {
            $table->text('url')->change();
            $table->text('url_us')->change();
            $table->text('url_au')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipe_sources', function (Blueprint $table) {
            $table->string('url')->change();
            $table->string('url_us')->change();
            $table->string('url_au')->change();
        });
    }
}
