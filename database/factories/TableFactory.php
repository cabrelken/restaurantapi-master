<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Table::class, function (Faker $faker) {
    $restaurant = $faker->randomElement(\App\Models\Restaurant::all());
    return [
       'name' => $faker->name,
       'restaurant_id' => $restaurant->id ,
    ];
});
