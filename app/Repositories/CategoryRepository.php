<?php

namespace App\Repositories;
 
use App\Models\Category;

class CategoryRepository  
{

    private $category;
    // Constructor to bind abo to repo
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function paginateDishes(int $page = 1, int $perPage = 10, $search)
    {
        $query = $this->category->dishes();
        if($search != ""){
            $query->Where('name', 'like', '%' . $search. '%');
        }; 

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function paginateCategories($page, $perPage, $withPaginate, $responsibleId, $search)
    {
        $query = Category::Where('responsible_id', '=', $responsibleId);
        
        if($search != ""){
            $query->Where('name', 'like', '%' . $search. '%');
        }
        
        if($withPaginate == 1){
            $categories = $query->paginate($perPage, ['*'], 'page', $page);
        }else{
            $categories = $query->get();
        }
        return $categories;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function create(string $name , int $responsibleId)
    {
        $category = new Category ;
        $category->name = $name ;
        $category->responsible_id = $responsibleId;
        $category->save();
        return $category;
    }
    
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update(string $name)
    {
        $this->category->name = $name ;
        $this->category->save();
        return $this->category;
    }

}

