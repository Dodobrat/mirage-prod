<?php

namespace App\Modules\Index\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Index\Models\Index;

class IndexController extends Controller
{
    public function index(){

        $index = Index::active()->reversed()->with(['media'])->first();

        return view('index::front.index',compact('index'));
    }
}
