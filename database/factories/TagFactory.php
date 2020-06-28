<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(1),
        'exchange_id' => $faker->biasedNumberBetween($min = 1, $max = 20),
    ];
});