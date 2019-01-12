<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Stack::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'user_id' => rand(1,51),
        'video_id' => $faker->imageUrl($width = 640, $height = 480),
        'media_type' => 'image'
    ];
});
