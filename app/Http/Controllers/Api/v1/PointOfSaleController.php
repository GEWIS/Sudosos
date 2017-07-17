<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PointOfSale;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PointOfSaleController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/pointsofsale",
     *     summary = "Returns all points of sale.",
     *     tags = {"POS"},
     *     description = "Returns all points of sale.",
     *     operationId = "getAllPointsOfSale",
     *     produces = {"application/json"},

     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     * ),
     */
    public function index(){
        $data = PointOfSale::all();
        return response()->json($data,200);
    }

    /**
     * @SWG\Post(
     *     path ="/pointsofsale",
     *     summary = "Create a new point of sale.",
     *     tags = {"POS"},
     *     description = "Create a new point of sale.",
     *     operationId = "createpointofsale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="Point of Sale",
     *         in="body",
     *         required=true,
     *         description="Model of the point of sale to store",
     *        @SWG\Schema(ref="#/definitions/inputPointOfSale"),
     *         ),
     *     @SWG\Response(
     *         response=201,
     *         description="Point of sale created",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid request",
     *     ),
     * ),
     */
    public function store(Request $request){

        $pos = PointOfSale::create($request->all());

        if ($pos->isValid()) {
            return response()->json($pos->id, 201);
        } else {
            return $this->response(400,"Invalid request", $pos->getErrors());
        }
    }

    /**
     * @SWG\Get(
     *     path ="/pointsofsale/{id}",
     *     summary = "Returns point of sale by id.",
     *     tags = {"POS"},
     *     description = "Returns a point of sale with a specified id.",
     *     operationId = "getpointofsale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Point of sale not found",
     *     ),
     * ),
     */
    public function getPointOfSale($id){
        $pos = PointOfSale::find($id);

        if ($pos) {
            return response()->json($pos, 200);
        } else {
            return $this->response(404, "Point of sale not found");
        }

    }

    /**
     * @SWG\Put(
     *     path ="/pointsofsale/{id}",
     *     summary = "Updates a point of sale by id.",
     *     tags = {"POS"},
     *     description = "Updates the point of sale.",
     *     operationId = "updatePointOfSale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="request",
     *         in="path",
     *         description="Request body in JSON.",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Point of sale succesfully updated",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Point of sale not valid",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Point of sale not found",
     *     ),
     * ),
     */
    public function putPointOfSale(Request $request, $id){
        $pos = PointOfSale::find($id);
        if ($pos) {
            $pos->update($request->all());
            if (!$pos->isValid()) {
                return $this->response(400,"Point of sale is invalid" ,$pos->getErrors());
            }
            return response()->json("Point of sale succesfully updated", 200);
        } else {
            return $this->response(404,"Point of sale not found");
        }

    }

    /**
     * @SWG\Delete(
     *     path="/pointsofsale/{id}",
     *     summary="Delete a point of sale by id.",
     *     description="Delete a point of sale by id.",
     *     operationId="deletePointOfSale",
     *     produces={"application/json"},
     *     tags={"POS"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Point of sale succesfully deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Point of sale not found."
     *     ),
     * )
     */
    public function deletePointOfSale($id){
        $pos = PointOfSale::find($id);
        if ($pos) {
            $pos->delete();
            return response()->json("Point of sale succesfully deleted", 200);
        } else {
            return $this->response(404,"Point of sale not found");
        }
    }

    /**
     * @SWG\Put(
     *     path ="/pointsofsale/{id}/reinstate",
     *     summary = "Reinstate a point of sale by id.",
     *     tags = {"POS"},
     *     description = "Reinstate a point of sale by id.",
     *     operationId = "reinstatePointOfSale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Point of sale succesfully reinstated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Point of sale not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Point of sale already active.",
     *     ),
     * ),
     */
    public function reinstatePointOfSale($id){
        if(PointOfSale::find($id)){
            return $this->response(409, "Point of Sale already active");
        }
        $pos = PointOfSale::withTrashed()->find($id);
        if($pos){
            $pos->restore();
            return response()->json("Point of Sale succesfully reinstated", 200);
        }else{
            return $this->response(404,"Point of sale not found");
        }

    }

    /**
     * @SWG\Get(
     *     path ="/pointsofsale/{id}/{property}",
     *     summary = "Returns a property of a point of sale by id.",
     *     tags = {"POS"},
     *     description = "Returns a property of a point of sale by id.",
     *     operationId = "getPointOfSaleProperty",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="property of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Point of sale not found",
     *     ),
     * ),
     */
    public function getPointOfSaleProperty($id, $property){
        $pos  = PointOfSale::find($id);
        if (!$pos) {
            return $this->response(404,"Point of sale not found");
        }
        if(Schema::hasColumn($pos->getTable(), $property)){
            return response()->json($pos->$property, 200);
        } else {
            return  $this->response(404,"Property not found");
        }
    }

    /**
     * @SWG\Put(
     *     path ="/pointsofsale/{id}/{property}",
     *     summary = "Update a property of a point of sale by id.",
     *     tags = {"POS"},
     *     description = "Update a property of a  point of sale by id.",
     *     operationId = "getPointOfSaleProperty",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *         @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the point of sale.",
     *         required=true,
     *         type="string",
     *     ),
     *         @SWG\Parameter(
     *         name="value",
     *         in="body",
     *         description="Request in JSON",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/inputProperty"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Point of sale succesfully updated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Point of sale not found",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid property value",
     *     ),
     * ),
     */
    public function putPointOfSaleProperty(Request $request, $id, $property){
        $pos = PointOfSale::find($id);
        if (!$pos) {
            return $this->response(404,"Point of sale not found");
        }
        if (Schema::hasColumn($pos->getTable(), $property)  && !(in_array($property,$pos->getGuarded()))) {
            $pos->$property = $request->value;
           if($pos->isValid()){
               $pos->save();
               return response()->json("Point of sale succesfully updated", 200);
            }
            return $this->response(400, "Invalid property value", $pos->getErrors());
        } else {
            return $this->response(404, "Property not found");
        }
    }
}