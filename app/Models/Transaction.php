<?php

namespace App\Models;
/**    @SWG\Definition(
 *               definition="getAllTransaction",
 *               required={},
 *      @SWG\Property(
 *             property="from",
 *             type="string",
 *             description="The timestamp of the lower bound of the requested range."
 *         ),
 *     @SWG\Property(
 *             property="to",
 *             type="string",
 *             description="The timestamp of the upper bound of the requested range."
 *         ),
 *      @SWG\Property(
 *             property="amount",
 *             type="integer",
 *             description="The number of recent transactions to be shown."
 *         ),
 *    )
 */
class Transaction extends BaseModel
{
    protected $fillable = [
        "sold_to_id",
        "authorized_id",
        "total_price",
        "activity_id",
        "comment",
    ];

    protected $protected = [
        "id", 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "sold_to_id" => "required|exists:users,id",
        "authorized_id" => "required|exists:users,id",
        "total_price" => "required|integer|min:0|max:9999999999",
        "activity_id" => "exists:activities",
        "comment" => "required|string",
    ];

    // Relations
    public function subtransactions(){
        return $this->belongsToMany('App\Models\Subtransaction');
    }
}
