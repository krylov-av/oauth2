<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Tag::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        'slug'=>Str::slug($faker->sentence),
    ];
});
