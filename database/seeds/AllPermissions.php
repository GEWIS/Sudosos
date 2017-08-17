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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $u = App\Models\User::where('user_code',6494)->first();
        $r = App\Models\RBAC\Role::first();
        $p = App\Models\RBAC\Permission::all();
        forEach($p as $permission){
            $r->permissions()->attach($permission);
        }
        $u->roles()->attach($r->id);

    }
}
