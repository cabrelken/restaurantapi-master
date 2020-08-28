<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Order;
use Auth;
use DB;

class OrderRepository  
{

    private $order;
    // Constructor to bind abo to repo
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function show() 
    {
        $this->order->dishes;
        $this->order->table;
        return $this->order;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function updateState(int $state)
    {
        $this->order->state = $state;
       
        $this->order->save();
        return $this->order;
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function updateAmounts($dishes)
    {
        foreach ($dishes as $dish) {
            $this->order->dishes()->detach($dish['dish_id']);
            $this->order->dishes()->attach($dish['dish_id'], ['amount' => $dish['amount']], true);
        } 

        return  $this->order;    
    }
}

