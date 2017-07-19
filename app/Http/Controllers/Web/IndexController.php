<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Swagger\Annotations\Schema;

class IndexController extends Controller
{

    public function index(){
        dd(Auth::user()->toJson());
        return View('app');
    }
}