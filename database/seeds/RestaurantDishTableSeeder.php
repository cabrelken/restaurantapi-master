<?php

use Illuminate\Database\Seeder;
use App\Models\Responsible;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Category;


class RestaurantDishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = Restaurant::findOrFail(1);
       
        $dishes = DB::table('responsibles')->where('responsibles.id','=',1)
        ->join('categories','responsibles.id','=','categories.responsible_id')
        ->join('dishes','categories.id','=','dishes.category_id')
        ->select('dishes.*')->get();
 
        for($i = 0; $i < $dishes->count() ; $i++){
            $restaurant->dishes()->attach(
                [$dishes[$i]->id],
                ['created_at'=> date('U'), 'updated_at'=> date('U')], 
                true
            );          
        }
    }
}
