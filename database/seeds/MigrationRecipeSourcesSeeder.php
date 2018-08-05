<?php

use Illuminate\Database\Seeder;

class MigrationRecipeSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sources = [
          'Ching\'s Click and Cook',
            'For Tenderstem',
            'For RSPCA Freedom Food',
            'Ching\'s Fast Food Book',
            'Ching\'s Eat Clean: Wok yourself to Health Book ',
            'Wok Yourself to Health Book',
            'www.chinghehuang.com',
            'Ching\'s China Modern'
        ];

        foreach ($sources as $k=>$v){
            $insert = New \App\Models\RecipeSource();
            $insert->name = $v;
            $insert->save();
        }
    }
}
