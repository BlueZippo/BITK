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

$factory->define(App\CollectionStack::class, function (Faker $faker) {
    return [
        'stack_id' => rand(111, 310),
        'collection_id' => rand(53, 72),
        
    ];
});
