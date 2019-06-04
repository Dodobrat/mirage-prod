<?php

namespace App\Modules\Team\Http\Controllers;

use App\Modules\Team\Models\Member;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Charlotte\Administration\Helpers\Settings;

class TeamController extends Controller
{
    public function index(){

        $members = Member::active()->reversed()->with(['media'])->get();

        SEOTools::setTitle(config('app.name') . ' - ' . Settings::getTranslated('team_meta_title'));
        SEOTools::setDescription(Settings::getTranslated('team_meta_description'));
        SEOMeta::addKeyword(explode(', ', Settings::getTranslated('team_meta_keywords')));

        return view('team::front.index', compact('members'));
    }
}
