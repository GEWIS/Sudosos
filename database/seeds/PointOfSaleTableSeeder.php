<?php

use Illuminate\Database\Seeder;

class PointOfSaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PointOfSale::class, 10)->create();
    }
}
