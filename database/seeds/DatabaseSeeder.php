<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ResponsiblesTableSeeder::class);
        $this->call(CategorysTableSeeder::class); 
        $this->call(DishsTableSeeder::class); 
        $this->call(RestaurantsTableSeeder::class); 
        $this->call(RestaurantDishTableSeeder::class); 
        $this->call(TablesTableSeeder::class); 
        $this->call(OrdersTableSeeder::class); 
        $this->call(OrderDishTableSeeder::class); 
    }
}
