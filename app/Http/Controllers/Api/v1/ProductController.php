<?php

namespace App\Http\Controllers\Api\v1;
use App\Models\Product;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(){
        return Product::all();
    }

    public function getProduct($id){
        $product = Product::find($id);

        if($product){
            return response()->json($product,200);
        } else {
            return response()->json("No product found", 404);
        }

    }

    public function store(Request $request){

        $product = Product::create($request->all());

        if($product->isValid()){
            return response()->json($product->id,200);
        }else {
            return response()->json([
                stat
            ],401);
        }
    }
}
