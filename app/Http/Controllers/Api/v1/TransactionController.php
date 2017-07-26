<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Subtransaction;
use App\Models\Transaction;
use App\Http\Controllers\Controller;

use function GuzzleHttp\Promise\is_fulfilled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class TransactionController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/transactions",
     *     summary = "Returns all transactions.",
     *     tags = {"transaction"},
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
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
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
        if($amount < 0) $this->response(404, "Negative amount of messages requested");
        if(!is_null($from)) if(!strtotime($from)) return $this->response(404, "From field is not a valid timestamp");
        if(!is_null($to)) if(!strtotime($to)) return $this->response(404, "To field is not a valid timestamp");

        // if from and to are null, generate the default values
        if(is_null($from)) $from = date("Y-m-d H:i:s", null);
        if(is_null($to)) $to = date("Y-m-d H:i:s"); // default today

        // actually perform the request
        if(!is_null($amount)) {
            $transactions = Transaction::with('subtransactions')->where('created_at', '>', $from)->where('created_at', '<=', $to)->take($amount)->get();
        }else $transactions = Transaction::with('subtransactions')->where('created_at', '>', $from)->where('created_at','<=', $to)->get();

        // return the request
        return response()->json($transactions, 200);
    }

    /**
     * @SWG\Get(
     *     path ="/transactions/user",
     *     summary = "Returns all transactions of a single user.",
     *     tags = {"transaction"},
     *     description = "Returns all transactions of a single user, either within a certain range with the from and to parameter, or a certain number.",
     *     operationId = "getAllTransactionsOfUser",
     *     produces = {"application/json"},
     *         @SWG\Parameter(
     *         name="request",
     *         in="body",
     *         description="Request in JSON, specifies the lower bound of the range of which all transactions are returned, default unix epoch",
     *         required=false,
     *         @SWG\Schema(ref="#/definitions/getAllTransactionUser"),
     *     ),
     *         @SWG\Parameter(
     *         name="id",
     *         in="body",
     *         description="Id of the user",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/getAllTransactionUser"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Not a valid request, see message body",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="UserID has not made any transaction, userID not found in table Transactions",
     *     ),
     * ),
     */
    public function getTransactionOfUser(Request $request, $id){
        $from = $request->from;
        $to = $request->to;
        $amount = $request->amount;
        $transactions = null;
        $nrOfTransactions = Transaction::where('sold_to_id', '=', $id)->count();


        // generate all error messages
        if(is_null($id)) return $this->response(400, "Field userID is empty");
        if($nrOfTransactions <= 0) return $this->response(404, "UserID has not made any transaction, userID not found in table Transactions");
        if($amount < 0) return $this->response(400, "Negative amount of messages requested");
        if(!is_null($from)) if(!strtotime($from)) return $this->response(400, "From field is not a valid timestamp");
        if(!is_null($to)) if(!strtotime($to)) return $this->response(400, "To field is not a valid timestamp");

                // if from and to are null, generate the default values
        if(is_null($from)) $from = date("Y-m-d H:i:s", null);
        if(is_null($to)) $to = date("Y-m-d H:i:s"); // default today

        // actually perform the request
        if(!is_null($amount)) $transactions = Transaction::with('subtransactions')->where('sold_to_id', '=', $id)->where('created_at', '>=', $from)->where('created_at','<=', $to)->take($amount)->get();
        else $transactions = Transaction::with('subtransactions')->where('sold_to_id', '=', $id)->where('created_at', '>=', $from)->where('created_at','<=', $to)->get();

        // return the request
        return response()->json($transactions, 200);
    }


    /**
     * @SWG\Get(
     *     path ="/transactions/{id}",
     *     summary = "Returns transaction by id.",
     *     tags = {"transaction"},
     *     description = "Returns a transaction with a specified id.",
     *     operationId = "getTransaction",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the transaction",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Transaction not found",
     *     ),
     * ),
     */
    public function getTransaction($id){
        $transaction = Transaction::with('subtransactions')->find($id);

        if ($transaction) {
            return response()->json($transaction, 200);
        } else {
            return $this->response(404,"Transaction not found");
        }
    }

    /**
     * @SWG\Get(
     *     path ="/transactions/activity/{id}",
     *     summary = "Returns transaction by activity id.",
     *     tags = {"transaction"},
     *     description = "Returns transactions with a specified activity id.",
     *     operationId = "getByActivity",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the activity",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Activity not found",
     *     ),
     * ),
     */
    public function getByActivity($id){
        $transaction = Transaction::with('subtransactions')->where('activity_id', '=', $id)->get();

        if ($transaction) {
            return response()->json($transaction, 200);
        } else {
            return $this->response(404,"Transaction not found");
        }
    }
    
    /**
     * @SWG\Post(
     *     path ="/transactions",
     *     summary = "Create a new transaction.",
     *     tags = {"transaction"},
     *     description = "Create a new transaction.",
     *     operationId = "createTransaction",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="transaction",
     *         in="body",
     *         required=true,
     *         description="Model of the transaction to store",
     *        @SWG\Schema(ref="#/definitions/inputTransaction"),
     *         ),
     *     @SWG\Response(
     *         response=201,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Transaction or subtransaction invalid.",
     *     ),
     * ),
     */
    public function createTransaction(Request $request){
        // put subtransactions in documentation!

        $subtransactions = $request->subtransaction;

        $transaction = Transaction::create($request->all());
        if ($transaction->isValid()) {
            for($i =0; $i < sizeof($subtransactions); $i++){
                $sub = app('App\Http\Controllers\Api\v1\SubtransactionController')
                    ->createSubtransaction($subtransactions[$i], $transaction->id);
                if(!$sub->isValid())  return $this->response(400,"Subtransaction invalid", $sub->getErrors());
            }
            return response()->json($transaction->id, 201);
        }else{
            return $this->response(400,"Transaction invalid", $transaction->getErrors());
        }
    }
    
//    /**
//     * @SWG\Put(
//     *     path ="/transactions/{id}",
//     *     summary = "Updates a transaction by id.",
//     *     tags = {"transaction"},
//     *     description = "Updates the transaction.",
//     *     operationId = "updateTransaction",
//     *     produces = {"application/json"},
//     *     @SWG\Parameter(
//     *         name="request",
//     *         in="path",
//     *         description="Request body in JSON.",
//     *         required=true,
//     *         type="string",
//     *     ),
//     *     @SWG\Parameter(
//     *         name="id",
//     *         in="path",
//     *         description="Id of the transaction",
//     *         required=true,
//     *         type="string",
//     *     ),
//     *     @SWG\Response(
//     *         response=201,
//     *         description="Transaction succesfully deleted",
//     *     ),
//     *     @SWG\Response(
//     *         response=400,
//     *         description="Transaction not valid",
//     *     ),
//     *     @SWG\Response(
//     *         response=404,
//     *         description="Transaction not found",
//     *     ),
//     * ),
//     */
//    public function updateTransaction(Request $request, $id){
//        $transaction = Transaction::find($id);
//
//        if ($transaction) {
//            $transaction->update($request->all());
//            if($transaction->isValid()){
//                return response()->json("Transaction succesfully updated", 200);
//            }else{
//                return $this->response(400, "Transaction invalid",$transaction->getErrors());
//            }
//        } else {
//            return $this->response(404,"Transaction not found");
//        }

    }
    /**
     * @SWG\Delete(
     *     path="/transactions/{id}",
     *     summary="Delete a transaction by id.",
     *     description="Delete a transaction by id.",
     *     operationId="deleteTransaction",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the transaction",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Transaction succesfully deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Transaction not found."
     *     ),
     * )
     */
    public function deleteTransaction($id){
        $transaction = Transaction::find($id);
        $subtransaction = Subtransaction::where('transaction_id', $id)->get();
        if ($transaction) {
            for($i = 0; $i < sizeof($subtransaction);$i++){
                if(!$subtransaction[$i]){
                    return $this->response(404,"SubTransaction not found");
                }
                $subtransaction[$i]->delete();
            }
            $transaction->delete();
            return response()->json("Transaction succesfully deleted", 200);
        } else {
            return $this->response(404,"Transaction not found");
        }
    }
    
}