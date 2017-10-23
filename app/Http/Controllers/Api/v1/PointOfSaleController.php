<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\PointOfSale;
use App\Http\Controllers\Controller;
use App\Models\GEWIS\Organ;
use App\Models\Product;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PointOfSaleController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/pointsofsale/owner/{owner_id}",
     *     summary = "Returns all points of sale of an organ.",
     *     tags = {"POS"},
     *     description = "Returns all points of sale of an organ.",
     *     operationId = "getAllPointsOfSale",
     *     produces = {"application/json"},
     *      @SWG\Parameter(
     *         name="owner_id",
     *         in="path",
     *         description="Id of the owner",
     *         required=true,
     *         type="integer",
     *         ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *      @SWG\Response(
     *         response=404,
     *         description="Owner not found",
     *     ),
     *
     * ),
     */
    public function index($owner_id){
        $organ = Organ::find($owner_id);
        if (!$organ) {
            $this->response(404, "Owner not found");
        }

        $points  = PointOfSale::where('owner_id', $owner_id)->get();
        if($points->isEmpty()){
            return $points;
        }
        $this->authorize('view', $points->first());
        return $points;
    }

    /**
     * @SWG\Post(
     *     path ="/pointsofsale",
     *     summary = "Create a new point of sale.",
     *     tags = {"POS"},
     *     description = "Create a new point of sale.",
     *     operationId = "createPointOfSale",
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
     *     @SWG\Response(
     *         response=404,
     *         description="Owner not found",
     *     ),
     * ),
     */
    public function store(Request $request){
        $owner = Organ::find($request->owner_id);

        if (!$owner) {
            return $this->response(404, 'Owner not found');
        }

        $this->authorize('create', [PointOfSale::class, $owner->id]);

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
     *     operationId = "getPointOfSale",
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
     *         description="Successful operation",
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
            $this->authorize('view', $pos);
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
     *         description="Request body in JSON, specifies a new point of sale",
     *         required=true,
     *         type="string",
     *        @SWG\Schema(ref="#/definitions/inputPointOfSale"),
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
            $this->authorize('update', $pos);
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
     *         description="Id of the point of sale",
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
            $this->authorize('delete', $pos);
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
     *         description="Id of the point of sale",
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
            $this->authorize('update', $pos);
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
     *         description="Id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the point of sale",
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
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid property value",
     *     ),
     * ),
     */
    public function getPointOfSaleProperty($id, $property){
        $pos  = PointOfSale::find($id);
        if (!$pos) {
            return $this->response(404,"Point of sale not found");
        }
        $this->authorize('view', $pos);

        if(Schema::hasColumn($pos->getTable(), $property)){
            return response()->json($pos->$property, 200);
        } else {
            return  $this->response(400,"Invalid property value");
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
     *    @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the point of sale.",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="value",
     *         in="body",
     *         description="Request body in JSON, specifies a new property value",
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
     *     @SWG\Response(
     *         response=409,
     *         description="Property is guarded",
     *     ),
     * ),
     */
    public function putPointOfSaleProperty(Request $request, $id, $property){
        $pos = PointOfSale::find($id);
        if (!$pos) {
            return $this->response(404,"Point of sale not found");
        }
        $this->authorize('update', $pos);
        if (Schema::hasColumn($pos->getTable(), $property)  && !(in_array($property,$pos->getGuarded()))) {
            $pos->$property = $request->value;
            if($pos->isValid()){
               $pos->save();
               return response()->json("Point of sale succesfully updated", 200);
            }
            return $this->response(400, "Invalid property value", $pos->getErrors());
        } else {
            if (Schema::hasColumn($pos->getTable(), $property)){
                return $this->response(409, "Property is guarded");
            } else {
                return $this->response(404, "Property not found");
            }
        }
    }
    /**
     * @SWG\Get(
     *     path ="/pointsofsale/{pos_id}/stores",
     *     summary = "Get all storages in a point of sale.",
     *     tags = {"POS"},
     *     description = "Get all storages in a point of sale.",
     *     operationId = "getStoragesPointOfSale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="pos_id",
     *         in="path",
     *         description="Id of the point of sale",
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
    public function getStoragesPointOfSale($id){
        $pointOfSale = PointOfSale::find($id);
        if(!$pointOfSale){
            return $this->response(404, "Point of sale not found");
        }else{
            $this->authorize('view', $pointOfSale);
            return response()->json($pointOfSale->storages, 200);
        }
    }


    /**
     * @SWG\Post(
     *     path ="/pointsofsale/{pos_id}/stores/{storage_id}",
     *     summary = "Attach a storage to a point of sale.",
     *     tags = {"POS"},
     *     description = "Attach a storage to a point of sale.",
     *     operationId = "postStoragePointOfSale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="pos_id",
     *         in="path",
     *         description="Id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="storage_id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Storage succesfully added to points of sale",
     *     ),

     *     @SWG\Response(
     *         response=404,
     *         description="Storage or point of sale not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Storage already attached to the point of sale",
     *     ),
     * ),
     */
    public function postStoragePointsOfSale($pos_id, $storage_id){
        $pos = PointOfSale::find($pos_id);
        $storage = Storage::find($storage_id);
        if (!$storage) {
            return $this->response(404, "Storage not found");
        }
        if (!$pos) {
            return $this->response(404, "Point of sale not found");
        }

        $this->authorize('update', [Storage::class,$storage]);
        $this->authorize('update', [PointOfSale::class,$pos]);

        // Adding storage of someone else thus required authentication of this person
       // TODO, validate usercode + pin if given


            if($pos->storages->contains($storage)){
                return $this->response(409, 'Storage already attach to this point of sale');
            }

            $pos->storages()->attach($storage);
            return response()->json("Storage successfully attached to the point of sale", 201);
    }
    /**
     * @SWG\Delete(
     *     path ="/pointsofsale/{pos_id}/stores/{storage_id}",
     *     summary = "Detach a storage from a points of sale.",
     *     tags = {"POS"},
     *     description = "Detach a storage from a points of sale.",
     *     operationId = "deleteStoragePointOfSale",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="pos_id",
     *         in="path",
     *         description="Id of the point of sale",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="storage_id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Storage succesfully detached from points of sale",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or point of sale not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Storage not attached to the point of sale",
     *     ),
     * ),
     */
    public function deleteStoragePointsOfSale($pos_id, $storage_id){
            $pos = PointOfSale::find($pos_id);
            $storage = Storage::find($storage_id);
            if (!$storage) {
                return $this->response(404, "Storage not found");
            }
            if (!$pos) {
                return $this->response(404, "Point of sale not found");
            }

            $this->authorize('delete', $pos);
            $this->authorize('delete', $storage);

            if (!$pos->storages->contains($storage)) {
                return $this->response(409, "Storage not attached to point of sale");
            } else {
                $pos->storages()->detach($storage);
                return response()->json("Storage succesfully detached from the point of sale", 200);
            }
        }
}