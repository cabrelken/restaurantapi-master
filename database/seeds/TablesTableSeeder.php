<?php

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Models\Table::class, 10)->create();
    $restaurant = Restaurant::findOrFail(1);
    $chars = ['A','B','C','D','E','F','G','H','J','I','M','N','O','P','K','R','S','T'];
    
    foreach($chars as $nameTable){
       $table = new Table;
       $table->name = $nameTable;
       $table->restaurant_id = $restaurant->id;
       $table->save(); 
    }
    
    }
}
