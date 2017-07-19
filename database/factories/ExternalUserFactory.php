<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ExternalUser::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'password' => bcrypt("secret"),
        'legacy_password' => "Test",
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'user_id' => App\Models\User::inRandomOrder()->first()->id,
    ];
});
