<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dish;

class Category extends Model
{

    protected $dateFormat = 'U';  
   
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

}
