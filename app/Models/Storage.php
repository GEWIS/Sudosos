<?php

namespace App\Models;
/**
 * @SWG\Definition(
 *      definition="storages",
 *      required={"id","name"},
 *      @SWG\Property(
 *             property="id",
 *             type="integer",
 *             description="The ID of the storage"
 *         ),
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the storage"
 *         ),
 *      @SWG\Property(
 *             property="owner_id",
 *             type="integer",
 *             description="ID of the owner from this storage"
 *         ),
 *         @SWG\Property(
 *             property="created_at",
 *             type="string",
 *             format="date-time",
 *             description="Time of creation"
 *         ),
 *         @SWG\Property(
 *             property="updated_at",
 *             type="string",
 *             format="date-time",
 *             description="Time of last update"
 *         ),
 *         @SWG\Property(
 *             property="deleted_at",
 *             type="string",
 *             format="date-time",
 *             description="Time of deletion (inactive)"
 *         ),
 *    )
 */
/**    @SWG\Definition(
 *               definition="inputStorage",
 *               required={"id","name"},
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the storage"
 *         ),
 *      @SWG\Property(
 *             property="owner_id",
 *             type="string",
 *             description="ID of the owner from this storage"
 *         ),
 *    )
 */

class Storage extends BaseModel
{
    protected $fillable = [
        "name", "owner_id"
    ];

    protected $protected = [
        "id", 'owner_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "name"     => "required|string|max:255",
        "owner_id" => "required|string|max:36|exists:users,id"
    ];


    // Relations
    public function products(){
        return $this->belongsToMany('App\Models\Product')
            ->withPivot('stock');
    }

    public function pointsOfSale(){
        return $this->belongsToMany('App\Models\PointOfSale','storage_pointofsale');
    }

}
