<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Responsible;
use App\Models\Table;
use App\Models\Order;
use Auth;

class CheckAcce
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $Objet )
    {
        $responsible = Auth::user();
        $haveAcce = false;

        if($Objet == "order"){
        
            $orderId = $request->route('orderId');
            $order = Order::findOrFail($orderId);
            $table = Table::findOrFail($order->table_id);
            $restaurantId = $table->restaurant_id;
            $haveAcce = $responsible->restaurants()->where('restaurants.id',$restaurantId)->exists();  
        
        }else if($Objet == "table"){
        
            $tableId = $request->route('tableId');
            $table = Table::findOrFail($tableId);
            $restaurantId = $table->restaurant_id;
            $haveAcce = $responsible->restaurants()->where('restaurants.id',$restaurantId)->exists();  
        
        }else if($Objet == "restaurant"){
        
            $restaurantId = $request->route('restaurantId');
            $haveAcce = $responsible->restaurants()->where('restaurants.id',$restaurantId)->exists();  
        
        }else if($Objet == "category"){
        
            $categoryId = $request->route('categoryId');
            $haveAcce = $responsible->categories()->where('categories.id',$categoryId)->exists();  
        
        }
        
        if($haveAcce){
            return $next($request);
        }
        
        abort(403);
    }
}
