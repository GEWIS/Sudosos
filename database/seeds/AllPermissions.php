<?php

use Illuminate\Database\Seeder;

class AllPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = App\Models\User::find('423c2a50-7135-11e7-ac20-177ce5d7b4f1');
        $r = App\Models\RBAC\Role::first();
        $p = App\Models\RBAC\Permission::all();
        forEach($p as $permission){
            $r->permissions()->attach($permission);
        }
        $u->roles()->attach($r);
    }
}
