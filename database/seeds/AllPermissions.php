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
        $u = App\Models\User::where('user_code', 6494)->first();
//        dd($u->getLastNameAttribute());
        $r = App\Models\RBAC\Role::first();
        $p = App\Models\RBAC\Permission::all();
        forEach($p as $permission){
            $r->permissions()->attach($permission);
        }
        $u->roles()->attach($r->id);

    }
}
