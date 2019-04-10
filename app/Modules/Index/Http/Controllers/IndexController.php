<?php

namespace App\Modules\Index\Http\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){

        return view('index::front.index');
    }
}
