<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
      

Route::group(['namespace' => 'Responsible'], function() {
  Route::post('login', 'ResponsibleController@login');
  Route::post('register', 'ResponsibleController@register');
 
  //auth
  Route::group(['middleware' => 'auth:apiResponsible'], function() {
    //accee dashbord
    Route::group(['middleware' => 'CheckPlatform:web'], function() {
      
      Route::get('details', 'ResponsibleController@show');
      Route::get('cashier/{cashierId}', 'ResponsibleController@cashier');
      Route::post('update', 'ResponsibleController@update');

      Route::group(['middleware' => 'CheckRole:Owner'], function() {
        Route::post('cashiers', 'ResponsibleController@cashiers');
      });

      //accee restaurant
      Route::group(['middleware' => 'CheckAcce:restaurant'], function() {
        //role owner
        Route::group(['middleware' => 'CheckRole:Owner'], function() {
          

          Route::group(['prefix' => 'responsible/{responsibleId}/restaurant/{restaurantId}'], function() {
            Route::get('addRestaurant', 'ResponsibleController@addRestaurant');
            Route::get('removeRestaurant', 'ResponsibleController@removeRestaurant');
          });
          
          Route::group(['prefix' => 'restaurant'], function() {
            Route::post('/{restaurantId}/allCashiers', 'RestaurantController@allCashiers');
            
            Route::post('/{restaurantId}' , 'RestaurantController@update');
            Route::get('/{restaurantId}/dish/{dishId}/removeDish', 'RestaurantController@removeDish');
            Route::get('/{restaurantId}/dish/{dishId}/addDish', 'RestaurantController@addDish');
            Route::post('/{restaurantId}/table', 'RestaurantController@createTable');
            Route::delete('/{restaurantId}', 'RestaurantController@delete');
            Route::post('/{restaurantId}/category/{idcategory}/alldishes', 'RestaurantController@allDishes');
          });      
        });
        
        Route::group(['prefix' => 'restaurant'], function() {
          Route::get('/{restaurantId}', 'RestaurantController@show');
          Route::post('{restaurantId}/orders/{state}', 'RestaurantController@orders');
          Route::post('/{restaurantId}/tables', 'RestaurantController@tables');
          Route::post('/{restaurantId}/category/{idcategory}/dishes', 'RestaurantController@dishes');
          Route::post('/{restaurantId}/categories', 'RestaurantController@categories');
          Route::post('/{restaurantId}/cashiers', 'RestaurantController@cashiers');
        });      
      });
      
      Route::post('restaurant', 'RestaurantController@create');
      Route::post('restaurants', 'RestaurantController@index');
      //accee table
      Route::group(['middleware' => 'CheckAcce:table'], function() {
        //accee owner
        Route::group(['middleware' => 'CheckRole:Owner'], function() {
          Route::post('table/{tableId}', 'TableController@update');
          Route::delete('table/{tableId}', 'TableController@delete');
        });
        Route::post('table/{tableId}/orders/{state}', 'TableController@orders');
        Route::post('table/{tableId}/payment', 'TableController@payment');
        Route::get('table/{tableId}', 'TableController@show');
      });
      
      //accee order
      Route::group(['middleware' => 'CheckAcce:order'], function() {
        Route::get('order/{orderId}', 'OrderController@show');
        Route::post('order/{orderId}', 'OrderController@updateState');
        Route::post('order/{orderId}/amounts', 'OrderController@updateAmounts');
        Route::delete('order/{orderId}', 'OrderController@delete');
      });
      
     //accee owner
      Route::group(['middleware' => 'CheckRole:Owner'], function() {
        Route::post('category', 'CategoryController@create');
        Route::post('categories', 'CategoryController@index');
        
        Route::group(['middleware' => 'CheckAcce:category'], function() {
          Route::get('category/{categoryId}', 'CategoryController@show');
          
          Route::post('category/{categoryId}', 'CategoryController@update');
          Route::post('category/{categoryId}/dish', 'CategoryController@createDish');
          Route::delete('category/{categoryId}', 'CategoryController@delete');
          
          Route::get('category/{categoryId}/dish/{dishId}', 'DishController@show');
          
          Route::post('category/{categoryId}/dishes', 'CategoryController@dishes');
          Route::post('category/{categoryId}/dish/{dishId}', 'DishController@update');
          Route::delete('category/{categoryId}/dish/{dishId}', 'DishController@delete');
        });
      });
    });

    //accee mobile
    Route::group(['middleware' => 'CheckPlatform:mobile'], function() {
      Route::post('mobile/{tableId}/orders/{state}', 'TableController@orders');
      Route::post('mobile/{tableId}/order', 'TableController@createOrder');
      Route::post('mobile/{tableId}/priceTotal', 'TableController@priceTotal');
      Route::post('mobile/{tableId}/category/{categoryId}/dishs', 'RestaurantController@dishesMobile');
      Route::post('mobile/{tableId}/categories', 'RestaurantController@categoriesMobile');
    });
    
    //All
    Route::post('logout', 'ResponsibleController@logout');
  });
  Route::post('timeNow', 'TableController@time');
});