<?php

use Illuminate\Database\Seeder;
use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;
use App\Models\User;
class RBACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create([
            'name' => 'view-products'
        ]);
       Permission::create([
            'name' => 'edit-products'
        ]);

        factory(Role::class, 5)->create()
            ->each(function($u) {
                $u->permissions()->save(Permission::inRandomOrder()->first());
            });
echo(User::all()->where('user_code','=', 6494));
        Role::inRandomOrder()->first()->users()->attach(User::all()->where('user_code','=', 6494));


    }
}
