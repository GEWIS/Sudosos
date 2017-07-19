<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\GEWIS\Organ::class, function (Faker\Generator $faker) {
    $name = $faker->name;
    $abbr = substr($name,0,3);
    return [
        'r_meeting_type' => "meeting_type",
        'r_meeting_number' => $faker->numberBetween(0,10000),
        'r_decision_point' => $faker->numberBetween(0,100000),
        'r_decision_number' => $faker->numberBetween(0,100000),
        'r_number' =>  $faker->numberBetween(0,100000),
        'abbr' => $abbr,
        'name' => $name,
        'type' => '1',
        'foundationDate' => '2016-01-01',
        'abrogationDate' => '2016-01-01',
    ];
});
