<?php
/**
 * Created by PhpStorm.
 * User: s149393
 * Date: 19-7-2017
 * Time: 13:41
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Subtransaction::class, function (Faker\Generator $faker) use ($factory){
    return [
        "transaction_id" => App\Models\Transaction::inRandomOrder()->first()->id,
        "product_id" => App\Models\Product::inRandomOrder()->first()->id,
        "storage_id" => App\Models\Storage::inRandomOrder()->first()->id,
        "amount" => $faker->numberBetween(1,10),
        "price_per_product" => $faker->numberBetween(1,10),
    ];
});
