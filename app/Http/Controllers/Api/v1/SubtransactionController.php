<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Transaction;
use App\Models\Subtransaction;
use App\Http\Controllers\Controller;

use function GuzzleHttp\Promise\is_fulfilled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SubtransactionController extends Controller{

    /**
     * @SWG\Post(
     *     path ="/transactions/{transaction_id}/subtransactions",
     *     summary = "Create a new subtransaction.",
     *     tags = {"transaction"},
     *     description = "Create a new subtransaction.",
     *     operationId = "createSubtransaction",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="subtransaction",
     *         in="body",
     *         required=true,
     *         description="Model of the transaction to store",
     *        @SWG\Schema(ref="#/definitions/inputSubtransaction"),
     *         ),
     *     @SWG\Response(
     *         response=201,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Subtransaction invalid.",
     *     ),
     * ),
     */
    public function createSubtransaction(Request $request,$transaction_id){
        $transaction = Transaction::find($transaction_id);
        if(!$transaction){
            return $this->response(404,"Transaction not found", $transaction->getErrors());
        }
        if(!$transaction->isValid()){
            return $this->response(400,"Transaction invalid", $transaction->getErrors());
        }
        $subtransaction = Subtransaction::create($request->all() + ['transaction_id' => $transaction_id]);
        if ($subtransaction->isValid()) {
                return response()->json($subtransaction->id, 201);
        }else{
                return $this->response(400,"Subtransaction invalid", $subtransaction->getErrors());
        }
    }


}