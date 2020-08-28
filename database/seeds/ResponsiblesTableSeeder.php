<?php

use Illuminate\Database\Seeder;
use App\Models\Responsible;

class ResponsiblesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // factory(App\Models\Restaurant::class, 2)->create();
       
       for($i = 0; $i < 30; $i++ ){
           $responsible = new Responsible;
           $responsible->name = "responsible".$i;
           $responsible->email = "responsible".$i."@gmail.com";
           $responsible->password = bcrypt('123456');
           if($i>1){
             $responsible->role = Responsible::ROLE_CASHIER;
           }else{
             $responsible->role = Responsible::ROLE_OWNER;
           }

           $responsible->save();
        }
       
        
    }
}
