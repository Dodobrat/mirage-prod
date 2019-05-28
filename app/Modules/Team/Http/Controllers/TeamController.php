<?php

namespace App\Modules\Team\Http\Controllers;

use App\Modules\Team\Models\Member;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Charlotte\Administration\Helpers\Settings;

class TeamController extends Controller
{
    public function index(){

        $members = Member::active()->reversed()->with(['media'])->get();

        SEOMeta::setTitle(config('app.name') . ' - ' . Settings::getTranslated('team_meta_title'));
        SEOMeta::setDescription(Settings::getTranslated('team_meta_description'));
        SEOMeta::addKeyword(explode(', ', Settings::getTranslated('team_meta_keywords')));
        OpenGraph::addImage(asset('/img/MV.png'), ['height' => 300, 'width' => 300]);

        return view('team::front.index', compact('members'));
    }
}
