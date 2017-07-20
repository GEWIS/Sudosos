<?php
use App\Models\User;
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ExternalUser::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'password' => bcrypt("secret"),
        'legacy_password' => "Test",
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'user_id' => User::inRandomOrder()->where('type',User::TYPE_EXTERNAL)->first()->id,
    ];
});
