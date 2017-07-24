<?php

namespace App\Models;

/**
 * @SWG\Definition(
 *      definition="product",
 *      required={"id","name","owner_id", "price", "tray_size", "category"},
 *      @SWG\Property(
 *             property="id",
 *             type="string",
 *             description="The ID of the product"
 *         ),
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the product"
 *         ),
 *      @SWG\Property(
 *             property="price",
 *             type="integer",
 *             description="The price in cents"
 *         ),
 *      @SWG\Property(
 *             property="image",
 *             type="string",
 *             description="The image displaying the product"
 *         ),
 *      @SWG\Property(
 *             property="tray_size",
 *             type="integer",
 *             description="Number of products in a tray of the product"
 *         ),
 *         @SWG\Property(
 *             property="category",
 *             type="string",
 *             enum={"Drink", "Food", "Ticket", "Other"},
 *             description="Category the product belongs to"
 *         ),
 *      @SWG\Property(
 *             property="owner_id",
 *             type="integer",
 *             description="ID of the owner from this product"
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
 *               definition="inputProduct",
 *               required={"id","name","owner_id", "price", "tray_size", "category"},
 *      @SWG\Property(
 *             property="name",
 *             type="string",
 *             description="The name of the product"
 *         ),
 *      @SWG\Property(
 *             property="price",
 *             type="integer",
 *             description="The price in cents"
 *         ),
 *      @SWG\Property(
 *             property="image",
 *             type="string",
 *             description="The image displaying the product"
 *         ),
 *      @SWG\Property(
 *             property="tray_size",
 *             type="integer",
 *             description="Number of products in a tray of the product"
 *         ),
 *      @SWG\Property(
 *             property="owner_id",
 *             type="string",
 *             description="ID of the owner from this product"
 *         ),
 *         @SWG\Property(
 *             property="category",
 *             type="string",
 *             default="other",
 *             enum={"drink", "food", "ticket", "other"},
 *             description="Category the product belongs to"
 *         ),
 *    )
 */
class Product extends BaseModel
{

     protected $fillable = [
        "name",
        "owner_id",
        "price",
        "image",
        "tray_size",
        "category",
    ];

    protected $guarded = [
       "id",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $rules = [
       "name"     => "required|string|max:255",
        "price"    => "required|integer|max:9999999999|min:0",
        "owner_id" => "required|integer|exists:mysql_gewisdb.Organ,id",
//        "image"    => "image",
        "tray_size" => "required|integer|max:9999999999|min:0",
        "category" => "required|string|in:drink,food,ticket,other",
    ];

    // Relations
    public function owner(){
        return $this->belongsTo('App\Models\GEWIS\Organ','owner_id');
    }

    public function storages(){
        return $this->belongsToMany('App\Models\Storage')
            ->withPivot('stock');
    }

}
