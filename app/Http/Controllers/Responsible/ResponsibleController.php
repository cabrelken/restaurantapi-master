<?php

namespace App\Http\Controllers\Responsible;

use App\Repositories\ResponsibleRepository;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CreateResponsibleRequest;
use App\Http\Requests\PaginateFormRequest;
use App\Models\Restaurant;
use App\Models\Responsible; 
use App\Models\Table; 

class ResponsibleController extends Controller
{

    /**
     * Method to delete task
     *
     * @param $res
     */
    public function show()
    {
        $responsible = Auth::user();
      
        return response()->json(['status' => 'success', 'data' => $responsible], 200);
    }

    
    /**
     * Method to delete task
     *
     * @param $res
     */
    public function update(CreateResponsibleRequest $request) 
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        
        $responsible = Auth::user();
        $nbr = Responsible::Where('email','=',$email)->count();
        if($nbr > 0 && $responsible->email != $email){
            return response()->json(['status' => 'notSuccess'], 400);
        }

        $success = ResponsibleRepository::update(
            $name,
            $email,
            $password
        );
      
        return response()->json(['status' => 'success', 'data' => $success], 200);
    }


    /**
     * Method to delete task
     *
     * @param $res
     */
    public function login(LoginRequest $request)
    { 
        $email = $request->input('email');
        $password = $request->input('password');
        $tabletId = $request->input('table_id',null);
        
        if(!(Auth::guard('responsible')->attempt(['email' => $email, 'password' => $password]))){
            return response()->json(['status' => 'notSuccess'], 200); 
        }
       
        $responsible = Auth::guard('responsible')->user();
       
        if( $tabletId == null){
            $token  = $responsible->createToken('web')->accessToken;
            $tokenRole = ['token' => $token , 'role' => $responsible->role];
            return response()->json(['status' => 'success', 'data' => $tokenRole], 200);
        }
        
        if(!(Table::where('tables.id', '=', $tabletId)->exists())){
            return response()->json(['status' => 'notSuccess'], 200); 
        }

        $table = Table::findOrFail($tabletId);
        
        if(!$responsible->restaurants()->where('restaurants.id', '=', $table->restaurant_id)->exists()){
            return response()->json(['status' => 'notSuccess'], 200);
        }
  
        $stringTableId = ''.$tabletId;
        $token  = $responsible->createToken($stringTableId)->accessToken;
        $restaurant = Restaurant::findOrFail($table->id);
        
        $data = [
            'token' => $token, 
            'tableId' => $tabletId, 
            'restaurantId' => $table->restaurant_id, 
            'tableName' => $table->name,
            'restaurantName' => $restaurant->name
        ];
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    
    /**
     * Method to delete task
     *
     * @param $res
     */
    public function register(CreateResponsibleRequest $request) 
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role',Responsible::ROLE_OWNER);
        
        $nbr = Responsible::Where('email','=',$email)->count();
        if($nbr > 0){
            return response()->json(['status' => 'notSuccess'], 400);
        }
        
        $success = ResponsibleRepository::register(
            $name,
            $email,
            $password,
            $role 
        );
      
        return response()->json(['status' => 'success', 'data' => $success], 200);
    }
    
    /**
     * Method to delete task
     *
     * @param $res
     */
    public function logout()
    {
        $responsible = Auth::user();
       
        $responsible->token()->revoke();
        $responsible->token()->delete();
       
        return response()->json(['status' => 'success'], 200);
    }
    
    /**
     * Method to delete task
     *
     * @param $res
     */
    public function cashiers(PaginateFormRequest $request)
    {
        $responsible = Auth::user();
       
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search  = $request->input('search', null);
        $responsibleRepository = new responsibleRepository($responsible);
        
        $cashiers = $responsibleRepository->paginateCashiers($page, $perPage, $search);
        
        return response()->json(['status' => 'success', 'data' => $cashiers], 200);
    }

     /**
     * Method to delete task
     *
     * @param $res
     */
    public function cashier($cashierId)
    {
        $cashier = Responsible::where('role', '=', Responsible::ROLE_CASHIER)->findOrFail($cashierId);
        $cashier->restaurants;
        return response()->json(['status' => 'success', 'data' => $cashier], 200);
    }

    
    /**
     * Method to delete task
     *
     * @param $res
     */
    public function addRestaurant($responsibleId, $restaurantId)
    {
        $responsible = Responsible::findOrFail($responsibleId);
        $restaurant = Restaurant::findOrFail($restaurantId);
      
        $existRestaurant = $responsible->restaurants()
        ->where('restaurants.id', '=', $restaurantId)
        ->exists();
        
        if ($existRestaurant){ 
            return response()->json(['status' => 'notSuccess'], 404);
        }
        
        $responsible->restaurants()->attach(
            $restaurant->id, 
            ['created_at'=> date('U'), 'updated_at'=> date('U')], 
            true
        );
        
        return response()->json(['status' => 'success', 'data' => $responsible], 200);
    }
    
    /**
     * Method to delete task
     *
     * @param $res
     */
    public function removeRestaurant($responsibleId, $restaurantId)
    {
        $responsible = Responsible::findOrFail($responsibleId);
        $restaurant = $responsible->restaurants()
        ->findOrFail($restaurantId);
           
        $responsible->restaurants()->detach($restaurant->id);
        
        return response()->json(['status' => 'success', 'data' => $responsible], 200);
    }
}

    