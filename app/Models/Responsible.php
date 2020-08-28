<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Restaurant;
use App\Models\Category;

class Responsible extends Authenticatable
{
   
    use HasApiTokens, Notifiable;
    
    protected $dateFormat = 'U';  
   
    const  ROLE_OWNER = 0 ;
    const  ROLE_CASHIER = 1 ;
    
    protected $hidden = [
        'password' ,
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class)->withPivot('created_at');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

}

  
