<?php

namespace App\Models\RBAC;
use App\Models\BaseModel;

/**
 * @SWG\Definition(
 *      definition="role",
 *      required={"id","owner_id","name"},
 *      @SWG\Property(
 *             property="id",
 *             type="string",
 *             description="The id of the product"
 *         ),
 *     @SWG\Property(
 *             property="owner_id",
 *             type="integer",
 *             description="The id of the organ it belongs to"
 *         ),
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the role"
 *         ),
 *    )
 */

/**    @SWG\Definition(
 *               definition="inputRole",
 *               required={"owner_id","name"},
 *     @SWG\Property(
 *             property="owner_id",
 *             type="integer",
 *             description="The id of the organ it belongs to"
 *         ),
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the role"
 *         ),
 *    )
 */
class Role extends BaseModel
{

    protected $fillable = ['name', 'owner_id'];


    public function users()
    {
        return $this->belongsToMany('App\Models\User','user_role');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\RBAC\Permission', 'permission_role');
    }

    public function hasPermission($permission){
        $result = $this->permissions->where('name', $permission)
            ->isEmpty() ? false : true;
        return $result;
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\GEWIS\Organ');
    }
}
