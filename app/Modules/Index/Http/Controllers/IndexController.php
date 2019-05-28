<?php

namespace App\Modules\Index\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Index\Models\Index;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Charlotte\Administration\Helpers\Settings;

class IndexController extends Controller
{
    public function index(){

        $index = Index::active()->reversed()->with(['media'])->first();

        SEOMeta::setTitle(config('app.name', 'Mirage Visulisation') . ' - ' . $index->title);
        SEOMeta::setDescription(Settings::get('website_description'));
        SEOMeta::addKeyword(explode(', ', Settings::get('website_keywords')));
        OpenGraph::addImage(asset('/img/MV.png'), ['height' => 300, 'width' => 300]);

        return view('index::front.index',compact('index'));
    }
}
