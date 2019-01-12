<?php

use Faker\Generator as Faker;

$factory->define(App\Collection::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'user_id' => rand(2, 25),
    ];
});

