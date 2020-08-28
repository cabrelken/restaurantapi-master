<?php

namespace App\Repositories;

use App\Models\Responsible;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class ResponsibleRepository 
{
    
    private $responsible;
    // Constructor to bind abo to repo
    public function __construct(Responsible $responsible)
    {
        $this->responsible = $responsible;
    }
    
   
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function register(string $name, string $email, string $password, string $role)
    {
        $responsible = new Responsible;
        $responsible->name = $name;
        $responsible->email = $email;
        $responsible->role = $role;
        $responsible->password = bcrypt($password);
        $responsible->save();
        
        $success['token'] = $responsible->createToken('web')-> accessToken; 
        return $success ;
    }
     
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function update(string $name, string $email, string $password)
    {
        $responsible = Auth::user();
        $responsible->name = $name;
        $responsible->email = $email;
        $responsible->password = bcrypt($password);
        $responsible->save();
        
        $success['token'] = $responsible->createToken('MyApp')-> accessToken; 
        return $success ;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateCashiers($page, $perPage, $search)
    {
        $query = DB::table('responsible_restaurant')
        ->where('responsible_restaurant.responsible_id','=',$this->responsible->id)
        ->join('responsible_restaurant as r2','r2.restaurant_id','=','responsible_restaurant.restaurant_id')
        ->join('responsibles as r3','r3.id','=','r2.responsible_id')
        ->where('r3.role','=','1')
        ->select('r3.id','r3.name','r3.email')
        ->distinct();
         
        if($search != ""){
            $query->Where('name', 'like', '%' . $search. '%');
        }
        
        $cashiers = $query->paginate($perPage, ['*'], 'page', $page);

        return $cashiers;
    }
}

