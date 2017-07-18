<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class IndexController extends Controller
{

    public function index(){
//        return file_get_contents(public_path().'/angular.html');
        dd(Auth::user()->toJson());
        return View('app');
    }
}