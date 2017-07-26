<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *      definition="pointOfSale",
 *      required={"id","owner_id","name"},
 *      @SWG\Property(
 *             property="id",
 *             type="string",
 *             description="The id of the Point of Sale"
 *         ),
 *      @SWG\Property(
 *             property="owner_id",
 *             type="integer",
 *             description="Id of the owner from this Point of Sale"
 *         ),
 *     @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the product"
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
 *               definition="inputPointOfSale",
 *               required={"owner_id", "name"},
 *      @SWG\Property(
 *             property="owner_id",
 *             type="integer",
 *             description="Id of the owner from this Point of Sale"
 *         ),
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the product"
 *         ),
 *    )
 */

/**    @SWG\Definition(
 *               definition="inputProperty",
 *               required={"value"},
 *      @SWG\Property(
 *             property="value",
 *             type="string",
 *             description="Value of the property"
 *         ),
 *    )
 */


class PointOfSale extends BaseModel
{
    protected $table = "pointsofsales";

    protected $fillable = [
        "name", "owner_id",
    ];

    protected $guarded = [
        "id", 'owner_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "name"     => "required|string|max:255",
        "owner_id" => "required|integer|exists:mysql_gewisdb.Organ,id",
    ];

    // Relations
    public function storages(){
        return $this->belongsToMany('App\Models\Storage','storage_pointofsale','pointofsale_id');
    }

    public function owner(){
        return $this->belongsTo('App\Models\GEWIS\Organ','owner_id');
    }

}