<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'user_code' => $faker->randomNumber(5),
        'pincode' => bcrypt($faker->randomNumber(4)),
        'balance' => $faker->numberBetween(-100,100),
        'card_id' => $faker->shuffle('hello, world'),
        'type' =>  $faker->numberBetween(0,3),
    ];
});
