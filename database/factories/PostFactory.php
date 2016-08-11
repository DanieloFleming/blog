<?php

/*
|--------------------------------------------------------------------------
| Post Factories
|--------------------------------------------------------------------------
|
*/

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
        'title' => $faker->title,
    ];
});
