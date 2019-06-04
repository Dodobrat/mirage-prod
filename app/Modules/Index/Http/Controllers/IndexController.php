<?php

namespace App\Modules\Index\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Index\Models\Index;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Charlotte\Administration\Helpers\Settings;

class IndexController extends Controller
{
    public function index(){

        $index = Index::active()->reversed()->with(['media'])->first();

        SEOTools::setTitle(config('app.name', 'Mirage Visulisation') . ' - ' . $index->title);
        SEOTools::setDescription(Settings::getTranslated('website_description'));
        SEOMeta::addKeyword(explode(', ', Settings::getTranslated('website_keywords')));

        return view('index::front.index',compact('index'));
    }
}
