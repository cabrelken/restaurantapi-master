<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Table;
use App\Models\Order;
use Auth;

class TableRepository  
{
    
    private $table;
    // Constructor to bind abo to repo
    public function __construct(Table $table)
    {
        $this->table = $table;
    }
   
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */ 
    public function paymentOrders()
    {
        $orders = $this->table->orders()
        ->where('orders.state', '=',Order::ORDER_UNPAIED)
        ->get();
        
        foreach($orders as $order){
            $order->state = Order::ORDER_PAIED;
            $order->save(); 
        }
        
        return $orders;
    }
    
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */ 
    public function paginateOrders(int $page, int $perPage, $withPaginate, $state, $timeClean)
    {
        $query = $this->table->orders();
        
        if(in_array($state, Order::STATES_ORDER)){
            $query->where('orders.state', '=', $state);
        }
        
        $query->with([
            'dishes' => function ($query) {
                return $query->orderBy('created_at', 'desc');
            }
        ]);

        if($timeClean != 0){
            $query->where('orders.created_at', '>', $timeClean);
        }
       
        if($withPaginate == 1){
            $orders = $query->paginate($perPage, ['*'], 'page', $page);
        }else{
            $orders = $query->get();
        }      
        
        return $orders;
    }


     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */ 
    public function priceTotal($timeClean)
    {
        $query = $this->table->orders();
        $query->where('orders.state', '=', Order::ORDER_UNPAIED);
        
        if($timeClean != 0){
            $query->where('orders.created_at', '>', $timeClean);
        }
        
        $query->with([
            'dishes' => function ($query) {
                return $query->orderBy('created_at', 'desc');
            }
        ]);

        $orders = $query->get();

        $priceTotal = 0;
        foreach($orders as $order){
           foreach($order->dishes as $dish){
               $priceTotal += $dish->price * $dish->pivot->amount; 
           }
        }

        return $priceTotal;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function create(string $name, int $restaurantId)
    {
        $table = new Table ;
        $table->name = $name ;
        $table->restaurant_id = $restaurantId;
    
        $table->save();
        return $table;
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update(string $name)
    {
        $this->table->name = $name;
        $this->table->save();
       
        return $this->table;
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function createOrder($dishes, int $state, int $tableId)
    {
        $order = new Order;
        $order->state = $state;
        $order->table_id = $tableId;
        $order->save();
        
        foreach ($dishes as $dish) {
            $order->dishes()->attach($dish['dish_id'], ['amount' => $dish['amount']], true);
        } 

        
        return  $order;    
    }

    
}

