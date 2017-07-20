<?php

use Illuminate\Database\Seeder;

class SubtransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Subtransaction::class, 10)->create();
    }
}
