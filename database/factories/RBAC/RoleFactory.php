<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RBAC\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(['inkoper','aspirant','fustenzwabber']),
        'owner_id' => App\Models\GEWIS\Organ::inRandomOrder()->first()->id,
    ];
});
