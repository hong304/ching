<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env("APP_SKIP_SEED", false) != true) {
           //run for false

            //Run ChingOldbSeeder first
            //Run ChingOldDbImagesToFilesSeeder before run MigrateRecipesSeeder
            //Run CountriesSeeder before run MigrateUsersSeeder
            //Run Recipe before run video

            if (env("APP_SKIP_SEED_OLD_DB", false) != true) {

            }
            $this->call(ChingOldDbSeeder::class);
            $this->call(ChingOldDbImagesToFilesSeeder::class);
            $this->call(MigrateRecipesSeeder::class);
            $this->call(MigrateVideoSeeder::class);
            $this->call(MigrateIngredientsSeeder::class);
            $this->call(CountriesSeeder::class);
            $this->call(MigrateUsersSeeder::class);
            $this->call(MigrateBlogsSeeder::class);
            $this->call(IngredientTypesSeeder::class);
            $this->call(NutritionsSeeder::class);
            $this->call(MigrationRecipeSourcesSeeder::class);
            $this->call(MigrationCharitySeeder::class);


        }else{



        }
    }
}
