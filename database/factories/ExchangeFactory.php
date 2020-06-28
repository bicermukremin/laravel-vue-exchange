<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Exchange;
use Faker\Generator as Faker;

$factory->define(Exchange::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'description' => $faker->sentence(10),
        'valuePrice' => $faker->biasedNumberBetween($min = 10, $max = 70),
        'user_id' => $faker->biasedNumberBetween($min = 1, $max = 30),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'country' => $faker->country,
        'city' => $faker->city,
        'tag_id' => $faker->biasedNumberBetween($min = 1, $max = 10),

    ];
});