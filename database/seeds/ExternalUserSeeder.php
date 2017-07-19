<?php

use Illuminate\Database\Seeder;

class ExternalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ExternalUser::class, 10)->create();
    }
}
