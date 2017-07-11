<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\PointOfSale::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'owner_id' => $faker->uuid,
    ];
});
