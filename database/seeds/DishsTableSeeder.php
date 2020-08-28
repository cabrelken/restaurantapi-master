<?php

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Category;


class DishsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //  factory(App\Models\Dish::class, 10)->create();
    $categories = Category::All();
    $j = 0;
    foreach($categories as $category){
       for($i = 0; $i < 15 ; $i++){
           $j++;
           $dish = new Dish;
           $dish->name = "plat".$j." ".$category->name;
           $dish->description = "Thon - Fromage - Fruit de mer - Frut - Scalop";
           $dish->price = 5.00;
           $dish->image = "https://pfe-imenu-api.dev.anypli.com/images/defaultImage.jpg";
           $dish->category_id = $category->id;
           $dish->save();
        }
    } 

    }
}
