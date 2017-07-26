<?php

namespace App\Models;

/**    @SWG\Definition(
 *               definition="inputSubtransaction",
 *               required={"product_id", "storage_id", "amount","price_per_product"},
 *      @SWG\Property(
 *             property="product_id",
 *             type="string",
 *             description="id of the product."
 *         ),
 *      @SWG\Property(
 *             property="storage_id",
 *             type="string",
 *             description="id of the storage."
 *         ),
 *      @SWG\Property(
 *             property="amount",
 *             type="integer",
 *             description="The amount of products bought."
 *         ),
 *     @SWG\Property(
 *             property="price_per_product",
 *             type="integer",
 *             description="The price of a single product."
 *         ),
 *    )
 */
class Subtransaction extends BaseModel
{
    protected $fillable = [
        "transaction_id",
        "product_id",
        "storage_id",
        "amount",
        "price_per_product",
    ];

    protected $protected = [
       'id','created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "transaction_id" => "required|exists:transactions,id",
        "product_id" => "required|exists:products,id",
        "amount" => "required|integer|min:1|max:9999999999",
        "storage_id" => "required|exists:storages,id",
        "price_per_product" => "required|integer|min:0|max:9999999999",

    ];

    // Relations
    public function transaction(){
        return $this->belongsTo('App\Models\Transaction');
    }
}
