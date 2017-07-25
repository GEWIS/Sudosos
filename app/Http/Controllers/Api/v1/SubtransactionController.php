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

    /**
     * @SWG\Get(
     *     path ="/transactions/{transaction_id}/subtransactions/{subtransaction_id}",
     *     summary = "Returns subtransaction by subtransaction id.",
     *     tags = {"transaction"},
     *     description = "Returns subtransactions with a specified subtransaction_id.",
     *     operationId = "getSubtransaction",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="transaction_id",
     *         in="path",
     *         description="Id of the transaction",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="subtransaction_id",
     *         in="path",
     *         description="Id of the subtransaction",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Subtransaction not found",
     *     ),
     * ),
     */
    public function getSubtransaction($transaction_id, $subtransaction_id){
        $transaction = Transaction::find($transaction_id);
        if(!isNull($transaction)){
            return $this->response(404,"Transaction not found", $transaction->getErrors());
        }

        $subtransaction = Subtransaction::find($subtransaction_id);

        if (!isNull($subtransaction)) {
            return response()->json($subtransaction, 201);
        }else{
            return $this->response(404,"Subtransaction not found", $subtransaction->getErrors());
        }

    }

    /**
     * @SWG\Delete(
     *     path ="/transactions/{transaction_id}/subtransactions/{subtransaction_id}",
     *     summary = "Deletes subtransaction by subtransaction id.",
     *     tags = {"transaction"},
     *     description = "Deletes subtransactions with a specified subtransaction_id.",
     *     operationId = "deleteSubtransaction",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="transaction_id",
     *         in="path",
     *         description="Id of the transaction",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="subtransaction_id",
     *         in="path",
     *         description="Id of the subtransaction",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Subtransaction not found",
     *     ),
     * ),
     */
    public function deleteSubtransaction($transaction_id, $subtransaction_id){
        $transaction = Transaction::find($transaction_id);
        if(!isNull($transaction)){
            return $this->response(404,"Transaction not found", $transaction->getErrors());
        }

        $subtransaction = Subtransaction::find($subtransaction_id);

        if (!isNull($subtransaction)) {
            return response()->json($subtransaction, 201);
        }else{
            return $this->response(404,"Subtransaction not found", $subtransaction->getErrors());
        }

    }

}