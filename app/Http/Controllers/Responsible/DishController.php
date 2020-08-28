<?php

namespace App\Http\Controllers\Responsible;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DishRepository;
use App\Models\Dish ;
use App\Http\Requests\DishFormRequest;
use App\Http\Requests\PaginateFormRequest;
use App\Models\Category ;
use File;
use DateTime;

class DishController extends Controller
{
    /**
    * Method to update task
    *
    * @param $request
    * @param $res
    */
    public function show($categoryId , $dishId)
    {
        $dish = Dish::findOrFail($dishId);
        
        if($dish->category_id != $categoryId){
            return response()->json(['status' => 'notSuccess'], 404);
        }
        
        return response()->json(['status' => 'success', 'data' => $dish], 200);
    }

    
    /**
    * Method to update task
    *
    * @param $request
    * @param $res
    */
    public function update(DishFormRequest $request, $categoryId , $dishId)
    {
       
        $dish = Dish::findOrFail($dishId);
        
        if($dish->category_id != $categoryId){
            return response()->json(['status' => 'notSuccess'], 404);
        }
        
        $image = "";
        $name = $request->input('name') ;
        $description = $request->input('description') ;
        $price = $request->input('price') ;

        if($request->file('image') != null){
            $nameImage = substr($dish->image, strrpos($dish->image, '/') + 1);
            $image_path = public_path("/images/".$nameImage);  
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $dt = new DateTime();
            $fileName =  $dt->format('U').".jpg";
            $path = $request->file('image')->move(public_path("/images"), $fileName);
            $image = url('/images/'.$fileName);
        }
       
        
        $dishRepositry = new DishRepository($dish); 
        $dish = $dishRepositry->update($name, $description, $image, $price);

        
        return response()->json(['status' => 'success', 'data' => $dish] , 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function delete($categoryId , $dishId)
    {
        $dish = Dish::findOrFail($dishId);
        
        if($dish->category_id != $categoryId){
            return response()->json(['status' => 'notSuccess'], 404);
        }
        
        $dish->delete();
        
        return response()->json([ 'status' => 'success'] , 200);
    }
    
    
}
