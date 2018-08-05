<?php

use Illuminate\Database\Seeder;

class NutritionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::transaction(function() {

        $old_nutritions = DB::connection('old')->select('SELECT * FROM recipe_nutritions ORDER BY id');

        $c = 0;

        DB::table('nutrition')->delete();

            foreach ($old_nutritions as $old_nutrition) {

                // show some progress dots
                $c++;
                if ($c % 200 == 0) echo $c;

                $nutrition = new \App\Models\Nutrition();
                $nutrition->recipe_id = $old_nutrition->rid;
                if ($old_nutrition->Cals && is_numeric($old_nutrition->Cals))
                    $nutrition->cals = $old_nutrition->Cals;
                if ($old_nutrition->Protein && is_numeric($old_nutrition->Protein))
                    $nutrition->protein = $old_nutrition->Protein;
                if ($old_nutrition->Carbs && is_numeric($old_nutrition->Carbs))
                    $nutrition->carbs = $old_nutrition->Carbs;
                if ($old_nutrition->Sugars && is_numeric($old_nutrition->Sugars))
                    $nutrition->sugars = $old_nutrition->Sugars;
                if ($old_nutrition->Fat && is_numeric($old_nutrition->Fat))
                    $nutrition->fat = $old_nutrition->Fat;
                if ($old_nutrition->SatFat && is_numeric($old_nutrition->SatFat))
                    $nutrition->satfat = $old_nutrition->SatFat;
                if ($old_nutrition->Fibre && is_numeric($old_nutrition->Fibre))
                    $nutrition->fibre = $old_nutrition->Fibre;
                if ($old_nutrition->Sodium && is_numeric($old_nutrition->Sodium))
                    $nutrition->sodium = $old_nutrition->Sodium;
                $nutrition->save();

            }

        });

    }
}
