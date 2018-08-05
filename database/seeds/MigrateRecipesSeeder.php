<?php

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\RecipeStep;
use App\Models\RecipeCourse;
use App\Models\RecipeTag;
use App\Models\Image;

class MigrateRecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * ==================================================================================================================
         * Recipe Model
         * ==================================================================================================================
         */
    
        $this->command->info("1. Migrating Recipes table...");
        $this->command->info("2. Making RecipeSteps table...");
   
        $old_recipes = DB::connection('old')->select('SELECT * FROM recipes ORDER BY recipes_id');
    
        foreach($old_recipes as $old_recipe) {
        
            $recipe = new Recipe();
            $recipe->id=$old_recipe->recipes_id;
            $recipe->active = $old_recipe->status;
            $recipe->recipe_course_id = $old_recipe->courses_id;
            $recipe->name = ucfirst(strtolower(preg_replace('/[^A-Za-z0-9&()," \-]/', '', $old_recipe->recipe_name))); // hardcore stripping of crap in DB
            $img = Image::select('id')->where('file_name','LIKE',$old_recipe->img .'.%')->first();
            $recipe->image_id = $img ? $img->id : NULL;
            
            if (strstr($old_recipe->serves,'('))
            {
                $recipe->serves_main = substr($old_recipe->serves,0,1);
                $recipe->serves_shared = substr($old_recipe->serves,2,1);
                $recipe->makes = NULL;
            }
            elseif (stristr($old_recipe->serves,'makes'))
            {
                $recipe->serves_main = NULL;
                $recipe->serves_shared = NULL;
                $recipe->makes = preg_replace("/[^0-9]/", "", $old_recipe->serves);
            } else {
                $recipe->serves_main = $old_recipe->serves;
                $recipe->serves_shared = NULL;
                $recipe->makes = NULL;
            }
                      
            $intro = str_replace('<br>', "\n", $old_recipe->intro);
            $recipe->intro = preg_replace('/[^A-Za-z0-9&(),.;*!" \-\n]/', '', html_entity_decode($intro)); // even more hardcore sanitation of dirt
            $recipe->tips = $old_recipe->tips; //thank fucking god there is no crap here.
    
            // prep time
            $p_time = $old_recipe->p_time;
            $p_time = trim(str_replace('+M*', '', $p_time));
            $mins = (strtotime($p_time) - time())/60; // convert string to minutes
            $recipe->preparation_time = $mins;
            // cooking time
            if ($old_recipe->c_time > 0)
            {
                $c_time =trim($old_recipe->c_time);
                if ($pos = strpos($c_time,'-')) $c_time = substr($c_time, $pos+1); // just take the higher of the range
                $mins = (strtotime($c_time) - time())/60; // convert string to minutes
                $recipe->cooking_time = $mins;
            } else {
                $recipe->cooking_time = 0;
            }

            $recipe->created_at = $old_recipe->add_date;
            $recipe->updated_at = $old_recipe->add_date;
            $recipe->save();
            
            // recipe steps
            // all start with   li&gt;  and end with    &lt;/li
            $steps_arr = preg_split('/&lt;li&gt;/', str_replace(['&lt;ol&gt;','&lt;/li&gt;','&lt;/ol&gt;','&lt;div&gt;','&lt;/div&gt;'], '', $old_recipe->how_to_cook));
            // now add all steps to recipe as objects
            $i = 0;
            unset($steps_arr[0]); // need to get rid of empty first step!
            foreach ($steps_arr as $old_step)
            {
                $step = new RecipeStep();
                $step->recipe_id = $old_recipe->recipes_id;
                $step->step_order = $i;
                $step->instruction = trim(html_entity_decode(str_replace('&#189;','&frac12;', str_replace('&#186;', '&deg;', $old_step))));
                // TODO Needs more tidying up in steps.. lots of weird HTML chars and unicode crap
                $step->save();
                $i++;
            }
                        
        
        }
    
        unset($steps_arr);
        unset($old_recipes);
    
    
        /*
         * ==================================================================================================================
         * RecipeCourse Model
         * ==================================================================================================================
         */
    
        $this->command->info("3. Migrating RecipesCourse table...");
    
        $old_courses = DB::connection('old')->select('SELECT * FROM courses ORDER BY courses_id');
    
        foreach($old_courses as $old_course)
        {
            $course = new RecipeCourse();
            $course->name = $old_course->courses;
            $course->save();
        }
    
        unset($old_courses);
    
        /*
         * ==================================================================================================================
         * RecipeTags Model
         * ==================================================================================================================
         */
    
        $this->command->info("4. Migrating RecipesTags (previously categories) table...");
    
        $old_cats = DB::connection('old')->select('SELECT * FROM categories ORDER BY categories_id');
    
        foreach($old_cats as $cat)
        {
            $tag = new RecipeTag();
            $tag->name = $cat->categories;
            $tag->save();
        }
    
        unset($old_cats);
    
        /*
         * ==================================================================================================================
         * Re-attach Tags to Recipes
         * ==================================================================================================================
         */
    
        $this->command->info("5. Re-attaching tags to recipes...(recipe_recipe_tag)");
    
        $old_cats = DB::connection('old')->select('SELECT * FROM recipe_categories');
    
        foreach($old_cats as $cat)
        {
            if ($recipe = Recipe::find($cat->recipe_id))
            {
                $recipe_tag = RecipeTag::find($cat->category_id);
                $recipe->tags()->attach($recipe_tag);
            }
            
        }
    
        unset($old_cats);

        DB::statement('alter table recipes MODIFY column id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY');

    }
}
