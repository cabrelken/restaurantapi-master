<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Restaurant ;

class Table extends Model
{

    protected $dateFormat = 'U'; 

    public function orders()
    {
       return $this->hasMany(Order::class);
    }

    public function restaurant()
    {
       return $this->belongsTo(Restaurant::class);
    }

}
