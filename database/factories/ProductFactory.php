<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Product::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'name' => $faker->name,
        'owner_id' => factory(App\Models\User::class)->create()->id,
        'price' => $faker->numberBetween($min = 1, $max = 2000),
        'image' => $faker->image(),
        'tray_size' => $faker->numberBetween($min = 1, $max = 24),
        'category' => $faker->randomElement(["drink","food","ticket","other"])
    ];
});
