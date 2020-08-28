<?php

namespace App\Http\Controllers\Responsible;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\DishRepository;
use App\Models\Category;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\PaginateFormRequest;
use App\Http\Requests\DishFormRequest;
use Auth;
use App\Models\Responsible;
use File;
use DateTime;

class CategoryController extends Controller
{
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function index(PaginateFormRequest $request)
    {
        $responsible = Auth::user();
     
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $withPaginate = $request->input('withPaginate', 1);
        $search = $request->input('search',null);
       
        $categories = CategoryRepository::paginateCategories($page, $perPage, $withPaginate, $responsible->id,$search);
        
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }
    
    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function show($categoryId)
    {
        $responsible = Auth::user();
     
        $category = $responsible->categories()->findOrFail($categoryId);
        
        return response()->json(['status' => 'success', 'data' => $category], 200);
    }
    

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function create(CategoryFormRequest $request)
    {
        $responsible = Auth::user();
        $name = $request->input('name');
        
        $category = CategoryRepository::create($name ,$responsible->id); 
        
        return response()->json(['status' => 'success', 'data' => $category], 200);
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update(CategoryFormRequest $request, $categoryId)
    {
        $responsible = Auth::user();
        $category = $responsible->categories()
        ->findOrFail($categoryId);
        
        $categoryRepository = new CategoryRepository($category);
        
        $name = $request->input('name') ;
        $categoryRepository->update($name);
        
        return response()->json([ 'status' => 'success', 'data' => $category ] , 200);
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function dishes(PaginateFormRequest $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search',null);
       
        $repository = new CategoryRepository($category);
        $dishes = $repository->paginateDishes($page, $perPage, $search);
        
        return response()->json(['status' => 'success', 'data' => $dishes], 200);
    }

    /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function createDish(DishFormRequest $request, $categoryId)
    {
        $responsible = Auth::user();
        $category = $responsible->categories()
        ->findOrFail($categoryId);
        
        if($request->file('image') != null){
            $dt = new DateTime();
            $fileName =  $dt->format('U').".jpg";
            $path = $request->file('image')->move(public_path("/images"), $fileName);
            $image = url('/images/'.$fileName);
        }else{
            $image = url('/images/defaultImage.jpg');
        }

        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
      
        
        $dish = DishRepository::create($name, $description, $image, $price, $categoryId);
        
        return response()->json(['status' => 'success', 'data' => $dish], 200);
    }


     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function delete(int $categoryId)
    {
        $responsible = Auth::user();
        $category = $responsible->categories()
        ->findOrFail($categoryId);
        
        $category->delete();
        
        return response()->json(['status' => 'success'], 200);
    }
}
