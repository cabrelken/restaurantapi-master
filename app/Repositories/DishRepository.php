<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Dish;
use Auth;

class DishRepository  
{

    private $dish;

    public function __construct(Dish $dish)
    {
        $this->dish = $dish;
    }
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function paginateDishs(int $page = 1, int $perPage = 10)
    {
        $dishs = Dish::paginate($perPage, ['*'], 'page', $page);
        
        return $dishs;
    }

     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public static function create(string $name, string $description, string $image, float $price, int $categoryId)
    {
        $dish = new Dish;
        $dish->name = $name;
        $dish->description = $description;
        $dish->image = $image;
        $dish->price = $price;
        $dish->category_id = $categoryId;
        
        $dish->save();
        
        return $dish;
    }
  
     /**
     * Method to update task
     *
     * @param $request
     * @param $res
     */
    public function update(string $name, string $description, string $image, float $price)
    {
        $this->dish->name = $name;
        $this->dish->description = $description;
        $this->dish->price = $price;
        if($image != ""){
            $this->dish->image = $image;
        }

        $this->dish->save();
        
        return $this->dish;
    }

}
