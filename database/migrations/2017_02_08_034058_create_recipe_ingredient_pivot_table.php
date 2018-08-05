<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeIngredientPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredient_section', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('recipe_id',false,true);
            $table->integer('recipe_ingredient_id',false,true);
            $table->integer('ingredient_section_id',false,true);
            $table->string('unit')->nullable();
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
        Schema::dropIfExists('recipe_ingredient_recipe__ingredient_section');
    }
}
