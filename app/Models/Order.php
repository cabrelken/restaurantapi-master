<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dish ;
use App\Models\Table ;

class Order extends Model
{
    
    protected $dateFormat = 'U'; 

    const ORDER_ANNULER = 0;
    const ORDER_UNPAIED = 1;
    const ORDER_PAIED= 2;
    const STATES_ORDER = [0 , 1 , 2];

    public function dishes(){
        return $this->belongsToMany(Dish::class)->withPivot('amount');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }


  
}
