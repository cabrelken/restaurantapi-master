<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Restaurant::class, function (Faker $faker) {
    $responsible = $faker->randomElement(\App\Models\Responsible::all());
    return [
        'email' => $faker->unique()->safeEmail,
        'name' =>  $faker->name,
        'responsible_id' => $responsible->id, 
    ];
});
