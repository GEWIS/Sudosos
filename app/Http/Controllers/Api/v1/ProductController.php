<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/products",
     *     summary = "Returns all products.",
     *     tags = {"Product"},
     *     description = "Returns all products.",
     *     operationId = "getAllProducts",
     *     produces = {"application/json"},

     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * ),
     */
    public function index(){
        $data = Product::all();
        return response()->json($data,200);
    }

    /**
     * @SWG\Post(
     *     path ="/products",
     *     summary = "Create a new product.",
     *     tags = {"Product"},
     *     description = "Create a new product.",
     *     operationId = "createProduct",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="Product",
     *         in="body",
     *         required=true,
     *         description="Model of the product to store",
     *        @SWG\Schema(ref="#/definitions/inputProduct"),
     *         ),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Product invalid.",
     *     ),
     * ),
     */
    public function store(Request $request){

        $product = Product::create($request->all());

        if ($product->isValid()) {
            return response()->json($product->id, 201);
        } else {
            return $this->response(400,"Product invalid", $product->getErrors());
        }
    }

    /**
     * @SWG\Get(
     *     path ="/products/{id}",
     *     summary = "Returns product by id.",
     *     tags = {"Product"},
     *     description = "Returns a product with a specified id.",
     *     operationId = "getProduct",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * ),
     */
    public function getProduct($id){
        $product = Product::find($id);

        if ($product) {
            return response()->json($product, 200);
        } else {
            return $this->response(404,"Product not found");
        }
    }
    /**
     * @SWG\Put(
     *     path ="/products/{id}",
     *     summary = "Updates a product by id.",
     *     tags = {"Product"},
     *     description = "Updates the product.",
     *     operationId = "updateProduct",
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
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Product succesfully updated",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Product not valid",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * ),
     */
    public function putProduct(Request $request, $id){
        $product = Product::find($id);

        if ($product) {
                $product->update($request->all());
                if($product->isValid()){
                    return response()->json("Product succesfully updated", 200);
                }else{
                    return $this->response(400, "Product invalid",$product->getErrors());
               }
        } else {
            return $this->response(404,"Product not found");
        }
    }

    /**
     * @SWG\Delete(
     *     path="/products/{id}",
     *     summary="Delete a product by id.",
     *     description="Delete a product by id.",
     *     operationId="deleteProduct",
     *     produces={"application/json"},
     *     tags={"Product"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Product succesfully deleted."
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found."
     *     ),
     * )
     */
    public function deleteProduct($id){
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json("Product succesfully deleted", 200);
        } else {
            return $this->response(404,"Product not found");
        }
    }

    /**
     * @SWG\Put(
     *     path ="/products/{id}/reinstate",
     *     summary = "Reinstate a product by id.",
     *     tags = {"Product"},
     *     description = "Reinstate a product by id.",
     *     operationId = "reinstateProduct",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Product succesfully reinstated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="Product already active",
     *     ),
     * ),
     */
    public function reinstateProduct($id){
        if(Product::find($id)){
            return $this->response(409,"Product already active.");
        }
        $product = Product::withTrashed()-> find($id);
        if($product){
            $product -> restore();
            return response() -> json("Product succesfully reinstated", 200);
        }else{
            return $this->response(404,"Product not found");
        }

    }
    /**
     * @SWG\Get(
     *     path ="/products/{id}/{property}",
     *     summary = "Returns a property of a product by id.",
     *     tags = {"Product"},
     *     description = "Returns a property of a product by id.",
     *     operationId = "getProductProperty",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the product",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found",
     *     ),
     * ),
     */
    public function getProductProperty($id, $property){
        $product = Product::find($id);
        if (!$product) {
            return $this->response(404,"Product not found");
        }
        if (Schema::hasColumn($product->getTable(), $property)) {
            return response()->json($product->$property, 200);
        } else {
            return  $this->response(404,"Property not found");
        }
    }
    /**
     * @SWG\Put(
     *     path ="/products/{id}/{property}",
     *     summary = "Update a property of a product by id.",
     *     tags = {"Product"},
     *     description = "Update a property of a product by id.",
     *     operationId = "getProductProperty",
     *     produces = {"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         required=true,
     *         type="string",
     *     ),
     *         @SWG\Parameter(
     *         name="property",
     *         in="path",
     *         description="Property of the product",
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
     *         response=404,
     *         description="Product not found",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Invalid property value",
     *     ),
     * ),
     */
    public function putProductProperty(Request $request, $id, $property){
        $product = Product::find($id);
        if (!$product) {
            return $this->response(404, "Product not found");
        }
        if (Schema::hasColumn($product->getTable(), $property) && !(in_array($property,$product->getGuarded()))){
            $product->$property = $request->value;
            if ($product->isValid()) {
                $product->save();
                return response()->json("Product succesfully updated", 200);
            }
            return $this->response(400, "Invalid property value", $product->getErrors());
        } else {
            return  $this->response(404,"Property not found");
        }
    }
}