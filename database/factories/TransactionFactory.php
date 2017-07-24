<?php
/**
 * Created by PhpStorm.
 * User: s149393
 * Date: 19-7-2017
 * Time: 13:41
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Transaction::class, function (Faker\Generator $faker) use ($factory) {
    $toReturn = [
        "sold_to_id" => App\Models\User::inRandomOrder()->first()->id,
        "authorized_id" => App\Models\User::inRandomOrder()->first()->id,
        "total_price" => $faker->numberBetween(1,10),
        "comment" => "this is a default comment"
    ];
    print_r ($toReturn);
    return $toReturn;
});
