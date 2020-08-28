<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    $table = $faker->randomElement(\App\Models\Table::all());
    return [
       'state' => $faker->numberBetween($min = 0, $max = 2),
        'table_id' => $table->id,
    ];
});
