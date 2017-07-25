<?php

use Illuminate\Database\Seeder;
use App\Models\RBAC\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = ['products', 'storages','pointsOfSale'];
        $functions = ['view', 'create', 'update', 'delete'];

        forEach($models as $model){
            forEach($functions as $function){
                $string = $function . '-' . $model ;
                Permission::create([
                    'name' => $string
                ]);
            }
        }
    }
}
