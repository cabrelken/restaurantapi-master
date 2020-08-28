<?php

namespace App\Http\Controllers\Responsible;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RestaurantFormRequest;
use App\Http\Requests\PaginateFormRequest;
use App\Http\Requests\DishIdsRequest;
use App\Http\Requests\TableFormRequest;
use App\Repositories\RestaurantRepository;
use App\Repositories\TableRepository;
use App\Models\Responsible; 
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Table;


class RestaurantController extends Controller
{
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function index(PaginateFormRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search', null);

        $restaurants = RestaurantRepository::paginateRestaurants($page, $perPage, $search);
        
        return response()->json(['status' => 'success', 'data' => $restaurants], 200);
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function show(int $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
       
        return response()->json(['status' => 'success', 'data' => $restaurant], 200);
    }
  
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function create(RestaurantFormRequest $request)
    {
       $responsible = Auth::user();
       
       $name = $request->input('name');
       $email = $request->input('email');      
       
       $nbr = Restaurant::Where('email','=',$email)->count();
        if($nbr > 0){
            return response()->json(['status' => 'notSuccess'], 400);
        }

       $restaurant = RestaurantRepository::create(
           $name, 
           $email, 
           $responsible->id 
        );
        
       return response()->json(['status' => 'success', 'data' => $restaurant], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update(RestaurantFormRequest $request, int $restaurantId)
    {
       $restaurant = Restaurant::findOrFail($restaurantId);
       
       $name = $request->input('name');
       $email = $request->input('email');      
       
       $nbr = Restaurant::Where('email','=',$email)->count();
       if($nbr > 0 && $restaurant->email != $email){
           return response()->json(['status' => 'notSuccess'], 400);
       }

       $restaurantRepository = new RestaurantRepository($restaurant);
       $restaurantRepository->update($name, $email);
     
       return response()->json(['status' => 'success', 'data' => $restaurant], 200);
    }

      /**
     * Method to delete task
     *
     * @param $res
     */
    public function cashiers(PaginateFormRequest $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
       
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', 'created_at');
        $orderDirection = $request->input('orderDirection', 'desc');
        $search = $request->input('search', null);

        $restaurantRepository = new RestaurantRepository($restaurant);
        $cashiers = $restaurantRepository->paginateCashiers(
            $page, 
            $perPage,
            $search
        );
        
        return response()->json(['status' => 'success', 'data' => $cashiers], 200);
    }

      /**
     * Method to delete task
     *
     * @param $res
     */
    public function allCashiers(PaginateFormRequest $request, $restaurantId)
    {
       
        $restaurant = Restaurant::findOrFail($restaurantId);
       
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $orderBy = $request->input('orderBy', 'created_at');
        $orderDirection = $request->input('orderDirection', 'desc');
        $search = $request->input('search', null);

        $restaurantRepository = new RestaurantRepository($restaurant);
        $cashiers = $restaurantRepository->paginateAllCashiers(
            $page, 
            $perPage,
            $search
        );
         
        return response()->json(['status' => 'success', 'data' => $cashiers], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function orders(PaginateFormRequest $request, $restaurantId, $state)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search',null);

        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $Orders = $restaurantRepository->paginateOrders($page, $perPage, $state, $search);
        
        return response()->json(['status' => 'success', 'data' => $Orders], 200);
    }
    
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function dishes(PaginateFormRequest $request, $restaurantId, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        
        $restaurant = Restaurant::findOrFail($restaurantId); 
        
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search',null);
  
        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $dishs = $restaurantRepository->paginateDishes($page, $perPage, $categoryId, $search);
        
        return response()->json(['status' => 'success', 'data' => $dishs], 200);
    }
    
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function allDishes(PaginateFormRequest $request, $restaurantId, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        
        $restaurant = Restaurant::findOrFail($restaurantId); 
        
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search',null);
  
        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $dishs = $restaurantRepository->paginateAllDishes($page, $perPage, $categoryId, $search);
        
        return response()->json(['status' => 'success', 'data' => $dishs], 200);
    }
    


    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function categories(PaginateFormRequest $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $withPaginate = $request->input('withPaginate', 1);
        $search = $request->input('search', "");

        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $categories = $restaurantRepository->paginateCategories($page, $perPage, $search, $withPaginate);
        
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function categoriesMobile(PaginateFormRequest $request, $tableId)
    {
        $table = Table::findOrFail($tableId);
        $restaurant = Restaurant::findOrFail($table->restaurant_id);
        
        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $search = $request->input('search', "");
        $page = 0;
        $perPage = 0;
        $withPaginate = 0;
        $categories = $restaurantRepository->paginateCategories($page, $perPage, $search, $withPaginate);
        
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function dishesMobile(PaginateFormRequest $request, $tableId, $categoryId)
    {
        $table = Table::findOrFail($tableId);
        $restaurant = Restaurant::findOrFail($table->restaurant_id);
        $category = Category::findOrFail($categoryId);
       
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search', "");

        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $dishs = $restaurantRepository->paginateDishes($page, $perPage, $categoryId, $search);
        
        return response()->json(['status' => 'success', 'data' => $dishs], 200);
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function tables(PaginateFormRequest $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search', "");
  
        $restaurantRepository = new RestaurantRepository($restaurant);
        
        $tables = $restaurantRepository->paginateTables($page, $perPage, $search);
        
        return response()->json(['status' => 'success', 'data' => $tables], 200);
    }
   
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function removeDish($restaurantId, $dishId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $dish = $restaurant->dishes()->findOrFail($dishId);
        
        $restaurantRepository = new RestaurantRepository($restaurant);
        $restaurantRepository->removeDish($dishId);
       
        return response()->json(['status' => 'success', 'data' => $restaurant], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function addDish($restaurantId, $dishId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $responsible = Auth::user();
        $dish = Dish::findOrFail($dishId);
        
        $responsible->categories()->findOrFail($dish->category_id);
        
        $restaurantRepository = new RestaurantRepository($restaurant);
        $restaurantRepository->addDish($dishId);
       
        return response()->json(['status' => 'success', 'data' => $restaurant], 200);
    }
   
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function createTable(TableFormRequest $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
      
        $table = TableRepository::create($request->input('name'), $restaurantId); 
      
        return response()->json(['status' => 'success', 'data' => $table], 200);
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function delete($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
       
        $restaurant->delete();
       
        return response()->json([ 'status' => 'success'], 200);
    }
}
