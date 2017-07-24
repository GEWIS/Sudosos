<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Transaction;
use App\Http\Controllers\Controller;

use function GuzzleHttp\Promise\is_fulfilled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransactionController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/transactions",
     *     summary = "Returns all transactions.",
     *     tags = {"Transaction"},
     *     description = "Returns all transactions, either within a certain range with the from and to parameter, or a certain number.",
     *     operationId = "getAllTransactions",
     *     produces = {"application/json"},
     *         @SWG\Parameter(
     *         name="from",
     *         in="body",
     *         description="Request in JSON, specifies the lower bound of the range of which all transactions are returned, default unix epoch",
     *         required=false,
     *         @SWG\Schema(ref="#/definitions/getAllTransaction"),
     *     ),
     *         @SWG\Parameter(
     *         name="to",
     *         in="body",
     *         description="Request in JSON, specifies the upper bound of the range of which all transactions are returned, default today",
     *         required=false,
     *         @SWG\Schema(ref="#/definitions/getAllTransaction"),
     *     ),
     *      @SWG\Parameter(
     *         name="amount",
     *         in="body",
     *         description="Request in JSON, number of transactions in the range to be returned",
     *         required=false,
     *         @SWG\Schema(ref="#/definitions/getAllTransaction"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Not a valid request, see message body",
     *     ),
     * ),
     */
    public function index(Request $request){
        $from = $request->from;
        $to = $request->to;
        $amount = $request->amount;
        $transactions = null;

        // generate all error messages
        if($amount < 0) return $this->response(400, "Negative amount of messages requested");
        if(!is_null($from)) if(!strtotime($from)) return $this->response(400, "From field is not a valid timestamp");
        if(!is_null($to)) if(!strtotime($to)) return $this->response(400, "To field is not a valid timestamp");

        // if from and to are null, generate the default values
        if(is_null($from)) $from = date("Y-m-d H:i:s", null);
        if(is_null($to)) $to = date("Y-m-d H:i:s"); // default today

        // actually perform the request
        if(!is_null($amount)) $transactions = Transaction::where('created_at', '<', $from)->where($to, '>=', 'created_at')->take($amount);
        else $transactions = Transaction::where('created_at', '>', $from)->where('created_at','<', $to)->get();

        // return the request
        return response()->json($transactions, 200);
    }
}