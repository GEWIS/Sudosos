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
$factory->define(App\Models\GEWIS\OrganMember::class, function (Faker\Generator $faker) {
    return [
        'organ_id' => App\Models\GEWIS\Organ::inRandomOrder()->first()->id,
        'lidnr' => App\Models\GEWIS\Member::inRandomOrder()->first()->lidnr,
        'r_meeting_type' => "meeting_type",
        'r_meeting_number' => $faker->numberBetween(0,10000),
        'r_decision_point' => $faker->numberBetween(0,100000),
        'r_decision_number' => $faker->numberBetween(0,100000),
        'function' => array_random(['general','chairman', 'pm']),
        'installDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'dischargeDate' => array_random([null, $faker->date($format = 'Y-m-d', $max = 'now')]),
    ];
});
