<?php

use Illuminate\Database\Seeder;

class MigrateIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info("1. Migrating ingredient_sections table...(ingredients_type)");

        $values = DB::connection('old')->select('SELECT * FROM ingredients_type ORDER BY ingredients_type_id');

        foreach ($values as $v){
            $ingredients = new \App\Models\IngredientSection();
            $ingredients->name = $v->ingredients_type;
            $ingredients->save();
        }

        $this->command->info("2. Migrating recipe_ingredients table...(ingredients)");

        $values = DB::connection('old')->select('SELECT * FROM ingredients ORDER BY ingredients_id');

        foreach ($values as $v){
            $ingredients = new \App\Models\RecipeIngredient();
            $ingredients->name = $v->food;
            $ingredients->save();
        }

        $this->command->info("3. Migrating recipe_ingredient_section table...(recipe_ingredients)");

        $values = DB::connection('old')->select('SELECT * FROM recipe_ingredients ORDER BY recipes_id');

        foreach($values as $v)
        {
            if ($recipe = \App\Models\Recipe::find($v->recipes_id))
            {
                $recipe_ingredient = \App\Models\RecipeIngredient::find($v->ingredients_id);
                $recipe_section = \App\Models\IngredientSection::find($v->type);

                $recipe->ingredients()->attach($recipe_ingredient,['unit'=>$v->unit,'ingredient_section_id'=>$recipe_section->id]);

               // $recipe->sections()->attach($recipe_section);
            }

        }

    }
}
