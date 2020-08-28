<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Dish::class, function (Faker $faker) {
    $category = $faker->randomElement(\App\Models\Category::all());
    return [
        'name' => $faker->name,
        'description' => $faker->name,
        'price' => $faker->randomFloat($nbMaxDecimals = 1, $min = 3, $max = 100),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'category_id' => $category->id,
    ];
});
