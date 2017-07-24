<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(ProductTableSeeder::class);
         $this->call(StorageTableSeeder::class);
         $this->call(PointOfSaleTableSeeder::class);
         $this->call(TransactionSeeder::class);
         $this->call(SubtransactionSeeder::class);
         $this->call(ExternalUserSeeder::class);


        /**
         * Only use when u have the gewisweb_test DB installed
         * This is used for login in using jwt token from the Web DB
         */
        $this->call(GEWISTableSeeder::class);
    }
}
