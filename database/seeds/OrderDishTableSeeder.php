<?php

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Table;
use App\Models\Order;
use App\Models\Restaurant;

class OrderDishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurant = Restaurant::findOrFail(1);
        
        $dishes = $restaurant->dishes;
        $orders = Order::all();
        // 
        
        foreach($orders as $order){
            $min = mt_rand(1, $dishes->count()-6);
            $max = mt_rand(1, 6);
            for ($i = $min; $i < ($min + $max); $i++) {
                $order->dishes()->attach($dishes[$i], ['amount' => mt_rand(1, 10)], true);   
            }
        }
    }
}
