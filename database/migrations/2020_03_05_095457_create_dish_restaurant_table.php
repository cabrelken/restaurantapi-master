<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishRestaurantTable extends Migration
{
    public function up()
    {
        Schema::create('dish_restaurant', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('restaurant_id');
            $table->unsignedInteger('dish_id');
            
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
          
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('dish_id')->references('id')->on('dishes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dish_restaurant');
    }
}
