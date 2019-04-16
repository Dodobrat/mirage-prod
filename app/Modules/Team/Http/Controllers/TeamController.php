<?php

namespace App\Modules\Team\Http\Controllers;

use App\Modules\Team\Models\Member;

use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index(){

        $members = Member::active()->reversed()->with(['media'])->get();

        return view('team::front.index', compact('members'));
    }
}
