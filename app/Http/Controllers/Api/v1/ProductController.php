<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Models\GEWIS\Organ;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller{
    /**
     * @SWG\Get(
     *     path ="/products/owner/{owner_id}",
     *     summary = "Returns all products for an organ.",
     *     tags = {"Product"},
     *     description = "Returns all products for an organ.",
     *     operationId = "getAllProducts",
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
     * ),
     */
    public function index($owner_id){
        $organ = Organ::find($owner_id);

        if(!$organ){
            $this->response(404, "Owner not found");
        }

        $products = Product::where('owner_id', $owner_id)->get();
        if($products->isEmpty()){
            return $products;
        }
        $this->authorize('view', $products->first());
        return $products;
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
     *         description="Successful operation",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Product invalid.",
     *     ),
     *    @SWG\Response(
     *         response=404,
     *         description="Owner not found",
     *     ),
     * ),
     */
    public function store(Request $request){
        $owner = Organ::find($request->owner_id);

        if(!$owner){
            return $this->response(404, 'Owner not found');
        }

        $this->authorize('create', [Product::class,$owner->id]);

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
     *         description="Product not found",
     *     ),
     * ),
     */
    public function getProduct($id){
        $product = Product::find($id);

        $this->authorize('view', $product);

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

            $this->authorize('update', $product);

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
            $this->authorize('delete', $product);


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
        $this->authorize('update', $product);

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
        $this->authorize('view', $product);

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
     *         response=201,
     *         description="Product succesfully updated",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Product not found",
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
    public function putProductProperty(Request $request, $id, $property){
        $product = Product::find($id);
        if (!$product) {
            return $this->response(404, "Product not found");
        }

        $this->authorize('update', $product);

        if (Schema::hasColumn($product->getTable(), $property) && !(in_array($property,$product->getGuarded()))){
            $product->$property = $request->value;
            if ($product->isValid()) {
                $product->save();
                return response()->json("Product succesfully updated", 200);
            }
            return $this->response(400, "Invalid property value", $product->getErrors());

        } else {

            if (Schema::hasColumn($product->getTable(), $property)){
                return @$this->response(409, "Property is guarded");
            } else {
                return  $this->response(404,"Property not found");
            }


        }
    }
}