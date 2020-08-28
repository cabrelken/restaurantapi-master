<?php

namespace App\Http\Controllers\Responsible;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Models\Order ;
use App\Http\Requests\OrderStateRequest;
use App\Http\Requests\OrderCreateRequest;
use Validator;

class OrderController extends Controller
{
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
   public function show(int $orderId)
    {
        $order = Order::findOrFail($orderId);
       
        $orderRepository = new OrderRepository($order);
        $orderRepository->show();
       
        return  response()->json(['status' => 'success', 'data' => $order], 200);
    }

     

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function updateState(OrderStateRequest $request, $orderId)
    { 
        $order = Order::findOrFail($orderId);
        $state = $request->input('state');
        
        if(!in_array($state, Order::STATES_ORDER)){
            return response()->json(['status' => 'notSuccess'], 404);    
        }

        $orderRepository = new OrderRepository($order);
        $orderRepository->updateState($state);
       
        return response()->json(['status' => 'success', 'data' => $order], 200);
    }


       /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function updateAmounts(OrderCreateRequest $request, $orderId)
    { 
        $order = Order::findOrFail($orderId);
        $dishes = $request->input('dishes');
        
        foreach($dishes as $dish){
           $dishExist = $order->dishes()->where('dishes.id','=',$dish['dish_id'])->exists();
           if(!$dishExist){
              return response()->json(['status' => 'notSuccess'], 404);    
           } 
        }
        
        $orderRepository = new OrderRepository($order);
        $orderRepository->updateAmounts($dishes);
       
        return response()->json(['status' => 'success', 'data' => $order], 200);
    }
    


     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function delete($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->delete();
       
        return response()->json(['status' => 'success'], 200);
    }
}
