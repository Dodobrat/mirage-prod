<?php

namespace App\Modules\Contacts\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    public function index(){

        return view('contacts::front.index');
    }
}
