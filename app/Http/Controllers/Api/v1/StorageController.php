<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\storage;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Swagger\Annotations\Schema;

class StorageController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/storages",
     *     summary = "Returns all storages.",
     *     tags = {"storage"},
     *     description = "Returns all storages.",
     *     operationId = "getAllStorages",
     *     produces = {"application/json"},

     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * ),
     */
    public function index(){
        $data = Storage::all();
        return response()->json($data,200);
    }

    /**
     * @SWG\Post(
     *     path ="/storages",
     *     summary = "Create a new storage.",
     *     tags = {"storage"},
     *     description = "Create a new storage.",
     *     operationId = "createStorage",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="storage",
     *         in="body",
     *         required=true,
     *         description="Model of the storage to store",
     *        @SWG\Schema(ref="#/definitions/inputStorage"),
     *         ),
     *     @SWG\Response(
     *         response=201,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Storage invalid.",
     *     ),
     * ),
     */
    public function store(Request $request){

        $storage = Storage::create($request->all());

        if ($storage->isValid()) {
            return response()->json($storage->id, 201);
        } else {
            return $this->response(400,"Storage invalid", $storage->getErrors());
        }
    }

    /**
     * @SWG\Get(
     *     path ="/storages/{id}",
     *     summary = "Returns storage by id.",
     *     tags = {"storage"},
     *     description = "Returns a storage with a specified id.",
     *     operationId = "getStorage",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage not found",
     *     ),
     * ),
     */
    public function getStorage($id){
        $storage = Storage::find($id);

        if ($storage) {
            return response()->json($storage, 200);
        } else {
            return $this->response(404,"Storage not found");
        }
    }
    /**
     * @SWG\Put(
     *     path ="/storages/{id}",
     *     summary = "Updates a storage by id.",
     *     tags = {"storage"},
     *     description = "Updates the storage.",
     *     operationId = "updateStorage",
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
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Storage succesfully deleted",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Storage not valid",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage not found",
     *     ),
     * ),
     */
    public function putStorage(Request $request, $id){
        $storage = Storage::find($id);

        if ($storage) {
            $storage->update($request->all());
            if($storage->isValid()){
                return response()->json("Storage succesfully updated", 200);
            }else{
                return $this->response(400, "Storage invalid",$storage->getErrors());
            }
        } else {
            return $this->response(404,"Storage not found");
        }

    }
    /**
     * @SWG\Delete(
     *     path="/storages/{id}",
     *     summary="Delete a storage by id.",
     *     description="Delete a storage by id.",
     *     operationId="deleteStorage",
     *     produces={"application/json"},
     *     tags={"storage"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Storage succesfully deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage not found."
     *     ),
     * )
     */
    public function deleteStorage($id){
        $storage = Storage::find($id);
        if ($storage) {
            $storage->delete();
            return response()->json("Storage succesfully deleted", 200);
        } else {
            return $this->response(404,"Storage not found");
        }
    }

    /**
     * @SWG\Put(
     *     path ="/storages/{id}/reinstate",
     *     summary = "Reinstate a storage by id.",
     *     tags = {"storage"},
     *     description = "Reinstate a storage by id.",
     *     operationId = "reinstateStorage",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Storage succesfully reinstated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Storage already active.",
     *     ),
     * ),
     */
    public function reinstateStorage($id){
        if(Storage::find($id)){
            return $this->response(409,"Storage already active.");
        }
        $storage = Storage::withTrashed()-> find($id);
        if($storage){
            $storage->restore();
            return response()->json("Storage succesfully reinstated", 201);
        }else{
            return $this->response(404,"Storage not found");
        }

    }
    /**
     * @SWG\Get(
     *     path ="/storages/{id}/{property}",
     *     summary = "Returns a property of a storage by id.",
     *     tags = {"storage"},
     *     description = "Returns a property of a storage by id.",
     *     operationId = "getStorageProperty",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or Property not found, see message body",
     *     ),
     * ),
     */
    public function getStorageProperty($id, $property){
        $storage = Storage::find($id);

        if (!$storage) {
            return $this->response(404,"Storage not found");
        }
        if (Schema::hasColumn($storage->getTable(), $property)) {
            return response()->json($storage->$property, 200);
        } else {
            return  $this->response(404,"Property not found");
        }
    }
    /**
     * @SWG\Put(
     *     path ="/storages/{id}/{property}",
     *     summary = "Update a property of a storage by id.",
     *     tags = {"storage"},
     *     description = "Update a property of a storage by id.",
     *     operationId = "getStorageProperty",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="request",
     *         in="path",
     *         description="Request body in JSON",
     *         required=true,
     *         type="string",
     *     ),
     *         @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Storage succesfully updated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or Property not found, see message body",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid property value",
     *     ),
     * ),
     */
    public function putStorageProperty(Request $request, $id, $property){
        $storage = Storage::find($id);
        if (!$storage) {
            return $this->response(404, "Storage not found");
        }
        if (Schema::hasColumn($storage->getTable(), $property)) {
            $storage->$property = $request->value;
            if ($storage->isValid()) {
                $storage->save();
                return response()->json("Storage succesfully updated", 201);
            }
            return $this->response(400, "Invalid property value", $storage->getErrors());
        } else {
            return  $this->response(404,"Property not found");
        }

    }

    /**
     * @SWG\Get(
     *     path ="/storages/{id}/stores",
     *     summary = "Returns all products in a storage by id.",
     *     tags = {"storage"},
     *     description = "Returns all products in a storage by id.",
     *     operationId = "getStorageProducts",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage not found",
     *     ),
     * ),
     */
    public function getStorageProducts($id){
        $storage = Storage::find($id);
        if (!$storage) {
            return $this->response(404, "Storage not found");
        }else{
            return response()->json($storage->products,200);
        }

    }

    /**
     * @SWG\Get(
     *     path ="/storages/{storage_id}/stock/{product_id}",
     *     summary = "Returns stock of a product in a storage by id.",
     *     tags = {"storage"},
     *     description = "Returns stock of a product in a storage by id.",
     *     operationId = "getStorageStockOfProducts",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="storage_id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="product_id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="request",
     *         in="path",
     *         description="Request body in JSON",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or relation between storage and product not found, see message body",
     *     ),
     * ),
     */
    public function getStorageStockOfProduct($storage_id, $product_id){
        $storage = Storage::find($storage_id);
        if (!$storage) {
            return $this->response(404, "Storage not found");
        }else if(!$storage->products->contains($product_id)){
                return $this->response(404, "Relation between Storage and Product not found");
        }else{
            return response()->json($storage->products->find($product_id)->pivot->stock,200);
        }
    }

    /**
     * @SWG\Put(
     *     path ="/storages/{storage_id}/stock/{product_id}",
     *     summary = "Sets the stock of a product in a storage by id.",
     *     tags = {"storage"},
     *     description = "Sets the stock of a product in a storage by id.",
     *     operationId = "putStorageStockOfProducts",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="storage_id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="product_id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="stock",
     *         in="body",
     *         description="Id of the product",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/inputProperty")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or Product or Relation between Storage and Product not found, see message body",
     *     ),
     * ),
     */
    public function putStorageStockOfProduct($storage_id, $product_id, Request $request){
        $storage = Storage::find($storage_id);
        $product = Product::find($product_id);
        if(!$storage) {
            return $this->response(404, "Storage not found");
        }else if(!$product){
            return $this->response(404, "Product not found");
        }else if(!$storage->products->contains($product_id)){
            return $this->response(404, "Relation between Storage and ProductS not found");
        }else{
            $storage->products()->sync([ $product_id => ["stock" => $request->value]]);
            return response()-> json("Successful operation",200);
        }
    }

    /**
     * @SWG\Post(
     *     path ="/storages/{storage_id}/stores/{product_id}",
     *     summary = "Stores a product in a storage by id.",
     *     tags = {"storage"},
     *     description = "Stores a product in a storage by id.",
     *     operationId = "putStorageStockOfProducts",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="storage_id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="product_id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="stock",
     *         in="body",
     *         description="Id of the product",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/inputProperty")
     *     ),
     *     @SWG\Parameter(
     *         name="request",
     *         in="path",
     *         description="Request body in JSON",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or Product not found, see return message",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid stock property",
     *     ),
     * ),
     */
    public function postStorageProduct(Request $request, $storage_id, $product_id){
        $storage = Storage::find($storage_id);
        $product = Product::find($product_id);
        if (!$storage) {
            return $this->response(404, "Storage not found");
        }else if (!$product) {
            return $this->response(404, "Product not found");
        }else{
            $stock = $request->value;
            if($stock->isValid()){
                $storage->products()->attach($product, ["stock" => $stock]);
                return response()->json("Product successfully stored in storage.",201);
            }else{
                return $this->response(400, "Invalid stock property.");
            }
        }

    }

    /**
     * @SWG\Delete(
     *     path ="/storages/{storage_id}/stores/{product_id}",
     *     summary = "Deletes a product in a storage by id.",
     *     tags = {"storage"},
     *     description = "Deletes a product in a storage by id.",
     *     operationId = "deleteStorageProduct",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="storage_id",
     *         in="path",
     *         description="Id of the storage",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="product_id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Storage or Relation between Storage and Product not found, see message body",
     *     ),
     * ),
     */
    public function deleteStorageProduct($storage_id, $product_id){
        $storage = Storage::find($storage_id);
        if (!$storage) {
            return $this->response(404, "Storage not found");
        }else if(!$storage->products->contains($product_id)){
            return $this->response(404, "Relation between Storage and Product not found");
        }else{
            $storage->products()->detach($product_id);
            return response()->json("Product succesfully deleted out of storage",200);
        }
    }
}

