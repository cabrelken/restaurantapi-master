<?php

use Illuminate\Database\Seeder;
use App\Models\Responsible;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Category;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Models\Restaurant::class, 10)->create();
        $responsibles = Responsible::where('role','=',Responsible::ROLE_OWNER)->get();
        $j = 0;
        foreach($responsibles as $responsible){
            $restaurantIds = [];
            for($i = 0; $i < 12 ; $i++){
                $j++;
                $restaurant = new Restaurant;
                $restaurant->name = "restaurant ".$j;
                $restaurant->email = "restaurant".$j."@gmail.com";
                $restaurant->save();
                $restaurantIds[] = $restaurant->id;
                DB::table('responsible_restaurant')->insert(
                    [
                        'responsible_id' => $responsible->id,
                        'restaurant_id' => $restaurant->id,
                        
                    ]
                );   
            }
        } 
     
        $responsibles = Responsible::where('role','=',Responsible::ROLE_CASHIER)->get();
        $restaurant = Restaurant::findOrFail(1);
     
        foreach($responsibles as $responsible){
                $responsible->restaurants()->attach(
                    $restaurant->id, 
                    ['created_at'=> date('U'), 'updated_at'=> date('U')], 
                    true
                );
        }
     
  
    }

    
}
