<?php

namespace App\Http\Controllers\Api\v1;
use App\Models\Product;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Swagger\Annotations\Schema;

class ProductController extends Controller
{

    public function index(){
        $data = Product::all();
        return $this->response($data,200, "Success");
    }


    public function store(Request $request){

        $product = Product::create($request->all());

        if($product->isValid()){
            return response()->json($product->id,200);
        }else {
            return response()->json([$product->getErrors()
            ],401);
        }
    }

    public function getProduct($id){
        $product = Product::find($id);

        if($product){
            return response()->json($product,200);
        } else {
            return response()->json("No product found", 404);
        }

    }

    public function putProduct(Request $request, $id){
        $product = Product::find($id);

        if($product){
            $product->save($request->all());
            return response()->json("Product succesfully updated", 200);
        }else{
            return response()->json("Product not found", 404);
        }

    }

    public function deleteProduct($id){
        $product = Product::find($id);
//        Schema::hasColumn()
        if($product){
            $product -> delete();
            return response()->json("Product succesfully deleted", 200);
        }else{
            return response()->json("Product not found", 404);
        }
    }

    public function putProductProperty($property, $value,  $id){
        $product = Product::find($id);

        if($product){
            $product->$property = $value;
            $product->save();
            return response()->json("Product succesfully updated", 200);
        }else{
            return response()->json("Product not found", 404);
        }

    }

}