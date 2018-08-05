<?php

use Illuminate\Database\Seeder;

class IngredientTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::transaction(function() {

            $old_ingredients = DB::connection('old')->select('SELECT * FROM ingredients ORDER BY food');

            DB::table('recipe_ingredients')->delete();
            DB::table('ingredient_types')->delete();

            //create ingredient types array and add the type to old_ingredients array
            $ingredientTypes = array();
            foreach ($old_ingredients as $old_ingredient) {
                //push value to ingredient types array
                $ingredientType = explode('(', $old_ingredient->food)[0];
                $ingredientType = strtolower(trim($ingredientType));

                $specialCases = array(
                    '0'=>array(
                        'wrong'=>"beansprouts",
                        'correct'=>"bean sprouts"
                    ),
                    '1'=>array(
                        'wrong'=>"blackberrie",
                        'correct'=>"blackberries"
                    ),
                    '2'=>array(
                        'wrong'=>"cape gooseberrie",
                        'correct'=>"cape gooseberries"
                    ),
                    '3'=>array(
                        'wrong'=>"chilli seasoning powder",
                        'correct'=>"chilli"
                    ),
                    '4'=>array(
                        'wrong'=>"eating apples, core removed and sliced into thin crescent slices",
                        'correct'=>"apple"
                    ),
                    '5'=>array(
                        'wrong'=>"lime wedges",
                        'correct'=>"lime"
                    ),
                    '6'=>array(
                        'wrong'=>"mangetout",
                        'correct'=>"mange tout"
                    ),
                    '7'=>array(
                        'wrong'=>"garlic chives",
                        'correct'=>"chives"
                    ),
                    '8'=>array(
                        'wrong'=>"gochugaru [korean dried chilli flakes]",
                        'correct'=>"chilli"
                    ),
                    '9'=>array(
                        'wrong'=>"japanese chilli flakes",
                        'correct'=>"chilli"
                    ),
                    '10'=>array(
                        'wrong'=>"mint leaves",
                        'correct'=>"mint"
                    ),
                    '11'=>array(
                        'wrong'=>'mung bean thread noodles <br>[aka "see through" noodles]',
                        'correct'=>"noodles"
                    ),
                    '12'=>array(
                        'wrong'=>"mushroom",
                        'correct'=>"mushroom(s)"
                    ),
                    '13'=>array(
                        'wrong'=>"mushrooms",
                        'correct'=>"mushroom(s)"
                    ),
                    '14'=>array(
                        'wrong'=>"noodle",
                        'correct'=>"noodles"
                    ),
                    '15'=>array(
                        'wrong'=>"nut",
                        'correct'=>"seeds and nuts"
                    ),
                    '16'=>array(
                        'wrong'=>"onions",
                        'correct'=>"onion"
                    ),
                    '17'=>array(
                        'wrong'=>"pearl river bridge dark soy sauce",
                        'correct'=>"sauce"
                    ),
                    '18'=>array(
                        'wrong'=>"peanut oil",
                        'correct'=>"oil"
                    ),
                    '19'=>array(
                        'wrong'=>"peppercorn",
                        'correct'=>"pepper"
                    ),
                    '20'=>array(
                        'wrong'=>"pickled beetroot, sliced",
                        'correct'=>"pickle"
                    ),
                    '21'=>array(
                        'wrong'=>"red rice",
                        'correct'=>"rice"
                    ),
                    '22'=>array(
                        'wrong'=>"seasame",
                        'correct'=>"sesame"
                    ),
                    '23'=>array(
                        'wrong'=>"seed",
                        'correct'=>"seeds and nuts"
                    ),
                    '24'=>array(
                        'wrong'=>"nuts",
                        'correct'=>"seeds and nuts"
                    ),
                    '25'=>array(
                        'wrong'=>"sichuan peppercorns",
                        'correct'=>"pepper"
                    ),
                    '26'=>array(
                        'wrong'=>"sichuan preserved vegetables",
                        'correct'=>"pickle"
                    ),
                    '27'=>array(
                        'wrong'=>"skinless, free-range, boneless chicken thighs",
                        'correct'=>"chicken"
                    ),
                    '28'=>array(
                        'wrong'=>"uncooked basmati & wild rice mix",
                        'correct'=>"rice"
                    ),
                    '29'=>array(
                        'wrong'=>"leaves watercress",
                        'correct'=>"watercress leave"
                    ),
                    '30'=>array(
                        'wrong'=>"sichuan peppercorns",
                        'correct'=>"pepper"
                    ),
                    '31'=>array(
                        'wrong'=>"pea",
                        'correct'=>"peas"
                    ),
                    '32'=>array(
                        'wrong'=>"nori seaweed",
                        'correct'=>"seaweed"
                    ),
                    '33'=>array(
                        'wrong'=>"organic long grain rice",
                        'correct'=>"rice"
                    ),
                    '34'=>array(
                        'wrong'=>"stock powder",
                        'correct'=>"stock"
                    ),
                    '35'=>array(
                        'wrong'=>"tenderstemÂ®",
                        'correct'=>"broccoli"
                    ),
                    '36'=>array(
                        'wrong'=>"mixed salad leaves e.g. red lettuce, spinach, rocket, watercress",
                        'correct'=>"mixed leaf"
                    ),
                    '37'=>array(
                        'wrong'=>"rainbow trout",
                        'correct'=>"fish"
                    ),
                    '38'=>array(
                        'wrong'=>"dofu ru [fermented soybean curd]",
                        'correct'=>"tofu"
                    ),


                );
                foreach ($specialCases as $key=>$specialCase){
                    if ($ingredientType == $specialCase['wrong']){
                        $ingredientType = $specialCase['correct'];
                        break;
                    }
                }
                array_push($ingredientTypes, $ingredientType);

                //set type value to each ingredient
                $old_ingredient->ingredientType = $ingredientType;

                //trim ingredient name and set ingredient name
                if (count(explode('(', $old_ingredient->food)) > 1){
                    $old_ingredient->name = explode('(', $old_ingredient->food)[1];
                    $old_ingredient->name = trim(explode(')', $old_ingredient->name)[0]);
                }else{
                    $old_ingredient->name = $old_ingredient->food;
                }

                $changeNameArr = array(
                    '0'=>array(
                        'id' => 46,
                        'name' => "fresh anise"
                    ),
                    '1'=>array(
                        'id' => 283,
                        'name' => "bean sprouts"
                    ),
                    '2'=>array(
                        'id' => 15,
                        'name' => "blackberries"
                    ),
                    '3'=>array(
                        'id' => 68,
                        'name' => "cape gooseberries"
                    ),
                    '4'=>array(
                        'id' => 106,
                        'name' => "garlic chives"
                    ),
                    '5'=>array(
                        'id' => 192,
                        'name' => "ground cumin"
                    ),
                    '6'=>array(
                        'id' => 171,
                        'name' => "honey"
                    ),
                    '7'=>array(
                        'id' => 321,
                        'name' => "honey"
                    ),
                    '8'=>array(
                        'id' => 201,
                        'name' => "kimchi"
                    ),
                    '9'=>array(
                        'id' => 252,
                        'name' => "baby leeks"
                    ),
                    '10'=>array(
                        'id' => 110,
                        'name' => "Little Gem lettuce"
                    ),
                    '11'=>array(
                        'id' => 335,
                        'name' => "Little Gem lettuce"
                    ),
                    '12'=>array(
                        'id' => 79,
                        'name' => "mange tout"
                    ),
                    '13'=>array(
                        'id' => 9,
                        'name' => "mint leaves"
                    ),
                    '14'=>array(
                        'id' => 381,
                        'name' => "mixed seeds (optional)"
                    ),
                    '15'=>array(
                        'id' => 112,
                        'name' => "vermicelli mung bean noodles"
                    ),
                    '16'=>array(
                        'id' => 95,
                        'name' => "black pepper"
                    ),
                    '17'=>array(
                        'id' => 336,
                        'name' => "black pepper"
                    ),
                    '18'=>array(
                        'id' => 97,
                        'name' => "fresh raw tiger prawn"
                    ),
                    '19'=>array(
                        'id' => 91,
                        'name' => "organic salmon fillet"
                    ),
                    '20'=>array(
                        'id' => 269,
                        'name' => "organic salmon fillet"
                    ),
                    '21'=>array(
                        'id' => 108,
                        'name' => "sea salt"
                    ),
                    '22'=>array(
                        'id' => 59,
                        'name' => "fresh tofu"
                    ),
                    '23'=>array(
                        'id' => 119,
                        'name' => "firm tofu"
                    ),
                    '24'=>array(
                        'id' => 352,
                        'name' => "firm tofu"
                    ),
                    '25'=>array(
                        'id' => 285,
                        'name' => "rice vinegar"
                    ),
                    '25'=>array(
                        'id' => 96,
                        'name' => "watercress leave"
                    ),
                );
                foreach ($changeNameArr as $c){
                    if ($c['id'] == $old_ingredient->ingredients_id){
                        $old_ingredient->name = $c['name'];
                        break;
                    }
                }
            }
            asort($ingredientTypes);
            $ingredientTypes = array_values(array_unique($ingredientTypes));

            //add to db
            foreach ($ingredientTypes as $key=>$ingredientType){
                foreach ($old_ingredients as $old_ingredient){
                    if ($ingredientType == $old_ingredient->ingredientType){
                        $ingred = new \App\Models\RecipeIngredient();
                        $ingred->id = $old_ingredient->ingredients_id;
                        $ingred->name = $old_ingredient->name;
                        $ingred->ingredient_type_id = $key + 1;
                        $ingred->save();
                    }
                }
                $ingred_type = new \App\Models\IngredientType();
                $ingred_type->id = $key + 1;
                $ingred_type->name = $ingredientType;
                $ingred_type->save();
            }

            //modify recipe_ingredient_section
            $changeIngredientArr = array(
                '0'=>array(
                    'from'=> [283],
                    'to'=> 103,
                ),
                '1'=>array(
                    'from'=> [116],
                    'to'=> 106,
                ),
                '2'=>array(
                    'from'=> [217],
                    'to'=> 192,
                ),
                '3'=>array(
                    'from'=> [171, 321],
                    'to'=> 20,
                ),
                '4'=>array(
                    'from'=> [335],
                    'to'=> 110,
                ),
                '5'=>array(
                    'from'=> [153],
                    'to'=> 79,
                ),
                '6'=>array(
                    'from'=> [111],
                    'to'=> 9,
                ),
                '7'=>array(
                    'from'=> [367],
                    'to'=> 112,
                ),
                '8'=>array(
                    'from'=> [336],
                    'to'=> 95,
                ),
                '9'=>array(
                    'from'=> [97],
                    'to'=> 86,
                ),
                '10'=>array(
                    'from'=> [269, 300],
                    'to'=> 91,
                ),
                '11'=>array(
                    'from'=> [108],
                    'to'=> 51,
                ),
                '12'=>array(
                    'from'=> [376],
                    'to'=> 282,
                ),
                '13'=>array(
                    'from'=> [352],
                    'to'=> 119,
                ),
                '14'=>array(
                    'from'=> [285],
                    'to'=> 126,
                ),
                '15'=>array(
                    'from'=> [146],
                    'to'=> 96,
                ),
            );

            foreach ($changeIngredientArr as $ci){
                DB::table('recipe_ingredient_section')
                    ->whereIn('recipe_ingredient_id', $ci['from'])
                    ->update(['recipe_ingredient_id'=> $ci['to']]);

                \App\Models\RecipeIngredient::whereIn('id', $ci['from'])->delete();
            }

            DB::table('recipe_ingredient_section')
                ->whereIn('recipe_id', [5, 49, 53])
                ->where('recipe_ingredient_id', 46)
                ->update(['recipe_ingredient_id'=>370]);
        });

    }
}
