<?php

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Table;
use App\Models\Order;
use App\Models\Restaurant;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Models\Restaurant::class, 10)->create();
        $restaurant = Restaurant::findOrFail(1);
        $tables = $restaurant->tables;
        
        $orders = [];
        foreach($tables as $table){
            for($i = 0;$i<10 ; $i++){
                $order = new Order;
                $order->table_id = $table->id;
                $order->state = mt_rand(0, 2);
                $order->save();
                $orders[] = $order;
            }
        }
    }
}
