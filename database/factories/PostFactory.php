<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'user_id'=> factory(\App\User::class),
        'title' => $faker->sentence,
        'body' => implode(' ',$faker->sentences),
        'status' => $faker->boolean(90),
        'category_id' =>factory(\App\Category::class)
    ];
});
