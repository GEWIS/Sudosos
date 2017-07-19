<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Transaction;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransactionController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/transactions,
     *     summary = "Returns all transactions.",
     *     tags = {"Transaction"},
     *     description = "Returns all transactions.",
     *     operationId = "getAllTransactions",
     *     produces = {"application/json"},
     *         @SWG\Parameter(
     *         name="from",
     *         in="body",
     *         description="Request in JSON",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/getAllTransaction"),
     *     ),
     *         @SWG\Parameter(
     *         name="to",
     *         in="body",
     *         description="Request in JSON",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/getAllTransaction"),
     *     ),
     *      @SWG\Parameter(
     *         name="amount",
     *         in="body",
     *         description="Request in JSON",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/getAllTransaction"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation.",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="No valid timestamp.",
     *     ),
     * ),
     */
    public function index(Request $request){
        $from = $request->from;
        $to = $request->to;
        $amount = $request->amount;
        if(is_null($from)){
            $from = date("Y-m-d H:i:s", null);
            dd($from);
        }else{
            $from = strtotime($from);
            if(!$from){
                return  $this->response(400,"No valid timestamp in from field");
            }
        }

        if(is_null($to)){
            $to = date("Y-m-d H:i:s");
        }else{
            $to = strtotime($to);
            if(!$to){
                return  $this->response(400,"No valid timestamp in to field");
            }
        }

        if(is_null($amount)){
            $transactions = Transaction::where($from < 'created_at' and 'created_at' < $to);
            return response()->json($transactions,200);
        }else if($amount > 0){
            $transactions = Transaction::where($from < 'created_at' and 'created_at' < $to)->take($amount);
            return response()->json($transactions,200);
        }else{
            return  $this->response(400,"Amount is negative");
        }
    }
}