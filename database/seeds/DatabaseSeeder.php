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
        $this->call(GEWISTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(StorageTableSeeder::class);
        $this->call(PointOfSaleTableSeeder::class);
        $this->call(ExternalUserSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RBACSeeder::class);
    }
}
