<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'body'=>$faker->paragraph(),
    ];
});
