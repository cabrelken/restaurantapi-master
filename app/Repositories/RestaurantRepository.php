<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Auth;
use App\Models\Responsible; 
use App\Models\Dish; 
use App\Models\Order; 
use App\Models\Category; 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class RestaurantRepository  
{
    
    private $restaurant;

    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateCashiers($page = 1, $perPage = 10, $search)
    {
        $responsiblesQuery = $this->restaurant->responsibles()->where('role', '=', Responsible::ROLE_CASHIER);
        if($search != null){
            $responsiblesQuery->Where('name', 'like', '%' . $search. '%');
        }
        $responsibles = $responsiblesQuery->paginate($perPage, ['*'], 'page', $page);
     
        return $responsibles;
    }
   
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */    
    public  function paginateAllCashiers($page = 1, $perPage = 10, $search)
    {
        $skip = $perPage * ($page - 1);
        
        $responsiblesQuery = Responsible::where('role', '=', Responsible::ROLE_CASHIER);
        if($search != null){
           $responsiblesQuery->Where('name', 'like', '%' . $search. '%');
        }
        $queryCount = $responsiblesQuery;
        $count  = intval($queryCount->count() / $perPage) + 1;
        $responsibles = $responsiblesQuery->skip($skip)->take($perPage)->get();
        

        $cashiersWithSubscriber =[];
        foreach($responsibles as $cashier){
            $isSubscriber = $this->restaurant->responsibles()
            ->where('responsibles.id','=',$cashier->id)
            ->exists();
            
            $cashiersWithSubscriber[] = ['isSubscriber' => $isSubscriber, 'cashier' => $cashier];
        }

        return ['last_page'=>$count,'cashiers' => $cashiersWithSubscriber];
    }
    
 
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function paginateRestaurants(int $page = 1, int $perPage = 10, $search)
    {
        $responsible = Auth::user();
        
        $query = $responsible->restaurants();
        if($search != ""){
            $query->Where('name', 'like', '%' . $search. '%');
        }
        $restaurants = $query->paginate($perPage, ['*'], 'page', $page);
        
        return $restaurants;
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateDishes(int $page = 1, int $perPage = 10, $categoryId ,$search)
    {
        $query = $this->restaurant->dishes()->where('category_id',$categoryId);

        if($search != ""){
            $query->Where('dishes.name', 'like', '%' . $search. '%');
        }

        $dishes = $query->paginate($perPage, ['*'], 'page', $page);
       
        return $dishes;
    }
 
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateAllDishes($page = 1, $perPage = 10, $categoryId, $search)
    {

        $skip = $perPage * ($page - 1);
        $query = Dish::where('category_id','=',$categoryId);
        
        if($search != ""){
            $query->Where('name', 'like', '%' . $search. '%');
        }
        
        $queryCount = $query;  
        $count  = intval($queryCount->count() / $perPage) + 1;
        $dishes = $query->skip($skip)->take($perPage)->get();
        
        $dishesWithSubscriber =[];
        foreach($dishes as $dish){
            $isSubscriber = DB::Table('dish_restaurant')
            ->where('restaurant_id',$this->restaurant->id)
            ->where('dish_id',$dish->id)->exists();
            
            $dishesWithSibscriber[] = ['isSubscriber' => $isSubscriber, 'dish' => $dish];
        }
        return ['last_page'=>$count,'dishes'=>$dishesWithSibscriber];
    }
 
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateCategories(int $page = 1, int $perPage = 10, $search,  $withPaginate)
    {
        $query = DB::Table('responsible_restaurant')
        ->where('restaurant_id','=',$this->restaurant->id)
        ->join('responsibles','responsible_id','=','responsibles.id')
        ->where('responsibles.role','=',Responsible::ROLE_OWNER)
        ->join('categories','categories.responsible_id','=','responsibles.id')
        ->select('categories.*');
        
        if($search != ""){
            $responsiblesQuery->Where('name', 'like', '%' . $search. '%');
        }

        if($withPaginate == 1){
            $categories = $query->paginate($perPage, ['*'], 'page', $page);
        }else{
            $categories = $query->get();
        }
     
        return $categories;
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateTables(int $page, int $perPage, string $search)
    {
        $query  = $this->restaurant->tables();
        if($search != ""){
            $query->Where('name', 'like', '%' . $search. '%');
        }
        $tables = $query->paginate($perPage, ['id','name'], 'page', $page);
     
        return $tables;
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateOrders(int $page, int $perPage, int $state, $search)
    {
        $ordersQuery = DB::table('tables')
        ->where('tables.restaurant_id', '=', $this->restaurant->id)
        ->join('orders', 'orders.table_id', 'tables.id');
        
        if(in_array($state, Order::STATES_ORDER)){
           $ordersQuery->where('orders.state', '=', $state);
        }
        
        $ordersQuery->orderBy('orders.created_at', 'desc')
        ->select('orders.*','tables.name');

        if($search != ""){
            $ordersQuery->Where('tables.name', 'like', '%' . $search. '%');
        }

        $orders = $ordersQuery->paginate($perPage, ['orders.*'], 'page', $page);
        
        return $orders;
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function addDish($dishId)
    {
        $dishIdExist = $this->restaurant->dishes()
        ->where('dishes.id','=', $dishId)                              
        ->exists();
       
        if(!$dishIdExist){
            $this->restaurant->dishes()->attach(
                [$dishId],
                ['created_at'=> date('U'), 'updated_at'=> date('U')], 
                true
            );    
        }
    }    
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function removeDish($dishId)
    {
       $this->restaurant->dishes()->detach($dishId);
    }    
    
    /**
     * Method to create a new task
     *
     * @param $request
     */
    public static function create($name, $email, $responsibleId)
    {
        $restaurant = new Restaurant;
        $restaurant->name = $name;
        $restaurant->email = $email;
        $restaurant->save();
        $responsible = Responsible::find($responsibleId);
        $responsible->restaurants()->attach(
            [$restaurant->id],
            ['created_at'=> date('U'),
            'updated_at'=> date('U')], 
            true
        );       
    }

    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update($name, $email)
    {
        $this->restaurant->name = $name;
        $this->restaurant->email = $email ;
        $this->restaurant->save();
    }

    
}





