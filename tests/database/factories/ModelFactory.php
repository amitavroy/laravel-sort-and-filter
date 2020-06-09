<?php

use Amitav\SortAndFilter\Tests\TestSupport\TestModel;
use Amitav\SortAndFilter\Tests\TestSupport\TestModelWithProp;
use Faker\Generator;

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(TestModel::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'age' => rand(18, 80),
        'country' => $faker->randomElement(['IND', 'AGF', 'USA', 'ZIM']),
        'wins' => rand(0, 10),
    ];
});

/* @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(TestModelWithProp::class, function (Generator $faker) {
    return [
        'name' => 'Amitav Roy',
        'age' => rand(18, 80),
        'country' => $faker->randomElement(['IND', 'AGF', 'USA', 'ZIM']),
        'wins' => rand(0, 10),
    ];
});
