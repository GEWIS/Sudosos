<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Swagger\Annotations\Schema;

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
        return response()-> json(Product::all(),200);
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
     *         description="operation unsuccessful",
     *     ),
     * ),
     */
    public function store(Request $request){

        $product = Product::create($request->all());

        if ($product->isValid()) {
            return response()->json($product->id, 201);
        } else {
            return response()->json($product->getErrors(), 400);
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
            return response()->json("No product found", 404);
        }

    }

    public function putProduct(Request $request, $id){
        $product = Product::find($id);

        if ($product) {
            $product->save($request->all());
            return response()->json("Product succesfully updated", 200);
        } else {
            return response()->json("Product not found", 404);
        }

    }

    public function deleteProduct($id){
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json("Product succesfully deleted", 200);
        } else {
            return response()->json("Product not found", 404);
        }
    }

    public function reinstateProduct($id){
        $product = Product::withTrashed()-> find($id);
        if($product){
           return response() -> json($product -> restore(), 200);
        }else{
            return response()->json("Product not found", 404);
        }

    }

    public function getProductProperty($property, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json("Product not found", 404);
        } else if (Schema::hasColumn($product->getTable(), $property)) {
            return response()->json($product->$property, 200);
        } else {
            return response()->json("Property not found", 404);
        }
    }

    public function patchProductProperty($property, $value, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json("Product not found", 404);
        } else if (Schema::hasColumn($product->getTable(), $property)) {
            $product->$property = $value;
            $product->save();
            return response()->json("Product succesfully updated", 200);
        } else {
            return response()->json("Property not found", 404);
        }

    }
}