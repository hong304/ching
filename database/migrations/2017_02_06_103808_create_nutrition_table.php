<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrition', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('recipe_id');
            $table->decimal('cals',7,2)->nullable();
            $table->decimal('protein',7,2)->nullable();
            $table->decimal('carbs',7,2)->nullable();
            $table->decimal('sugars',7,2)->nullable();
            $table->decimal('fat',7,2)->nullable();
            $table->decimal('satfat',7,2)->nullable();
            $table->decimal('fibre',7,2)->nullable();
            $table->decimal('sodium',7,2)->nullable();
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
        Schema::dropIfExists('nutrition');
    }
}
