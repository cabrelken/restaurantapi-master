<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\responsible;

class CategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namesCategories = ["Pizza", "sandwich", "ma9loubes", "Tabounas", "Poissons", "scallops", "crepes", "boissons", "desserts", "cafes", "glaces", "croissants", "Gateaux"];
        //factory(App\Models\Category::class, 10)->create();
        $responsibles = Responsible::where('role','=',Responsible::ROLE_OWNER)->get();
        foreach($responsibles as $responsible){
           foreach($namesCategories as $nameCategory){
               $category = new Category;
               $category->name = $nameCategory;
               $category->responsible_id = $responsible->id;
               $category->save();
           }
        }
    }
}
