<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Product::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'name' => $faker->name,
        'owner_id' => $faker->uuid,
//        'owner_id' => $factory->create(App\Models\User::class)->id,
        'price' => $faker->numberBetween($min = 1, $max = 2000),
        'image' => $faker->image(),
        'tray_size' => $faker->numberBetween($min = 1, $max = 24),
        'category' => $faker->randomElement(["drink","food","ticket","other"])
    ];
});
