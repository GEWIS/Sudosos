<?php

use App\Models\User;
use App\Models\UserRole;
use App\Models\GEWIS\Organ;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(UserRole::class, function (Faker\Generator $faker) use ($factory) {
    return [
        "user_id"=> User::inRandomOrder()->where([['type', User::TYPE_GEWIS],['user_code', 6494]])->first()->id,
        "abbr"=> Organ::inRandomOrder()->first()->abbr,
        "function"=> $faker->randomElement(['voorzitter','vieze-voorzitter','penning-meester']),
    ];
});
