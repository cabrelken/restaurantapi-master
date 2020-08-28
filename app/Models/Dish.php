<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant ;

class Dish extends Model
{

    protected $dateFormat = 'U'; 
    
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }

}
