<?php

namespace App\Http\Controllers\Responsible;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TableFormRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\PaginateFormRequest;
use App\Repositories\TableRepository;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\Order;
use Auth;

class TableController extends Controller
{
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function show(int $tableId)
    {
        $table = Table::findOrFail($tableId);
      
        return response()->json(['status' => 'success', 'data' => $table], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update(TableFormRequest $request, int $tableId)
    {
        $table = Table::findOrFail($tableId);  
        $name = $request->input('name');
       
        $repository = new TableRepository($table);
       
        $table = $repository->update($name); 
      
        return response()->json(['status' => 'success', 'data' => $table], 200);
    }
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function orders(PaginateFormRequest $request, $tableId, $state)
    {
        $table = Table::findOrFail($tableId);
       
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $withPaginate = $request->input('withPaginate', 1);
        $timeClean = $request->input('timeClean', 0);
 
        $tableRepository = new TableRepository($table);
        
        $Orders = $tableRepository->paginateOrders($page, $perPage, $withPaginate, $state, $timeClean);
        
        $data = ['tableId' => $table->id, 'tableName' => $table->name, 'orders'=>$Orders];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
 

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function priceTotal(PaginateFormRequest $request, $tableId)
    {
        $table = Table::findOrFail($tableId);
       
        $timeClean = $request->input('timeClean', 0);
 
        $tableRepository = new TableRepository($table);
        
        $priceTotal = $tableRepository->priceTotal($timeClean);
        
        $data = ['priceTotal' => $priceTotal];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function payment($tableId)
    {
        $table = Table::findOrFail($tableId);
       
        $tableRepository = new TableRepository($table);
        
        $tableRepository->paymentOrders();
        
        return response()->json(['status' => 'success'], 200);
    }
    
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function createOrder(OrderCreateRequest $request, int $tableId)
    {
        $table = Table::findOrFail($tableId);
       
        $dishes = $request->input('dishes');        
        
        $arrayDishIds = [];
        foreach($dishes as $dish){
            $arrayDishIds[] = $dish['dish_id']; 
        }
        $restaurant = $table->restaurant;
              
        $nbrDishIdsValide = $restaurant->dishes()
        ->whereIn('dishes.id', $arrayDishIds)
        ->count();                              
        
        if($nbrDishIdsValide != count($arrayDishIds)){
            return response()->json(['status' => 'notSuccess'], 404);
        }
        
        $order = TableRepository::createOrder($dishes, Order::ORDER_UNPAIED, $tableId);
        return response()->json(['status' => 'success', 'data' => $order], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function delete(int $tableId)
    {
        $table = Table::findOrFail($tableId);  
        $table->delete();
      
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */ 
    public function time()
    {
        return response()->json(['dateTime' => date('U')], 200);
    }

}