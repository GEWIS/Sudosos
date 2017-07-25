<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Storage::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'owner_id' => App\Models\GEWIS\Organ::inRandomOrder()->first()->id,
    ];
});
