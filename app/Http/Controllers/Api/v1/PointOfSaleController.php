<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PointOfSale;
use App\Http\Controllers\Controller;

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

    public function deletePointOfSale($id){
        $pos = PointOfSale::find($id);
        if ($pos) {
            $pos->delete();
            return response()->json("Point of sale succesfully deleted", 200);
        } else {
            return $this->response(404,"Point of sale not found");
        }
    }

    public function reinstatePointOfSale($id){
        $pos = PointOfSale::withTrashed()->find($id);
        if($pos){
            $pos->reinstate();
            return response() -> json("Point of Sale reinstated", 200);
        }else{
            return $this->response(404,"Point of sale not found");
        }

    }

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

    public function putPointOfSaleProperty(Request $request, $id, $property){
        $pos = PointOfSale::find($id);
        if (!$pos) {
            return $this->response(404,"Point of sale not found");
        }
        if (Schema::hasColumn($pos->getTable(), $property)) {
            $pos->$property = $request->value;
           if($pos->isValid()){
               $pos->save();
               return response()->json("Point of sale succesfully updated", 200);
            }
            return $this->response(400, "Invalid property value", $pos->getErrors());

        } else {
            return response()->json("Property not found", 404);
        }

    }
}