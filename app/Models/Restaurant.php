<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dish;
use App\Models\Table;
use App\Models\Responsible;

class Restaurant extends Model
{
   
    protected $dateFormat = 'U'; 
  
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
    
    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('created_at');
    }

    public function responsibles()
    {
        return $this->belongsToMany(Responsible::class)->withPivot('created_at');
    }

}

