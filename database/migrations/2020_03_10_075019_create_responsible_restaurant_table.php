<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsibleRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsible_restaurant', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('restaurant_id');
            $table->unsignedInteger('responsible_id');
            
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
      
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('responsible_id')->references('id')->on('responsibles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsible_restaurant');
    }
}
