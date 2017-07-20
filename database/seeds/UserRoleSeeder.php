<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       App\Models\User::create([
        'user_code' => 6494,
        'pincode' => "ASdsadsa",
        'balance' => 0,
        'card_id' => 'hello, world',
        'type' =>  0,
        ]);
        factory(App\Models\UserRole::class, 3)->create();
    }
}
