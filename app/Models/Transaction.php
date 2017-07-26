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
 *
 *      @SWG\Definition(
 *               definition="getAllTransactionUser",
 *               required={},
 *     @SWG\Property(
 *             property="userID",
 *             type="string",
 *             description="The ID of the user of who the transactions are requested."
 *         ),
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
 *      @SWG\Property(
 *             property="subtransaction",
 *             type="array",
 *             description="JSON array containing (multiple) subtransactions."
 *         ),
 *    )
 */

/**    @SWG\Definition(
 *               definition="inputTransaction",
 *               required={"sold_to_id", "authorized_id", "total_price", "activity_id","comment", "subtransaction"},
 *      @SWG\Property(
 *             property="sold_to_id",
 *             type="string",
 *             description="id of the person who bought the product."
 *         ),
 *      @SWG\Property(
 *             property="authorized_id",
 *             type="string",
 *             description="id of the person who authorized the transaction."
 *         ),
 *      @SWG\Property(
 *             property="total_price",
 *             type="int",
 *             description="Total price of the transaction."
 *         ),
 *      @SWG\Property(
 *             property="activity_id",
 *             type="string",
 *             description="The activity on which the transaction is made."
 *         ),
 *     @SWG\Property(
 *             property="comment",
 *             type="string",
 *             description="Comment which is set to a transaction."
 *         ),
 *     @SWG\Property(
 *             property="subtransaction",
 *             type="array",
 *             items = @SWG\Schema(ref="#/definitions/inputSubtransaction"),
 *             description="JSON array containing (multiple) subtransactions.",
 *
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
     //   "activity_id" => "exists:activities",
        "comment" => "required|string",
    ];

    // Relations
    public function subtransactions(){
        return $this->hasMany('App\Models\Subtransaction');
    }
}
