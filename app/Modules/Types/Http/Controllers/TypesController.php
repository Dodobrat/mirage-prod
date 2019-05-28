<?php

namespace App\Modules\Types\Http\Controllers;

use App\Modules\Projects\Models\Project;
use App\Modules\Types\Models\Type;
use App\Http\Controllers\Controller;
use App\Modules\Types\Models\TypeTranslation;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    private static $PER_PAGE = 12;

    public function index($slug)
    {

        $selected_type = Type::whereHas('translations', function ($query) use ($slug) {
            $query
                ->where('locale', \App::getLocale())
                ->where('slug', $slug);
        })->with(['categories'])->first();

        if (empty($selected_type)) {
            $translation = TypeTranslation::where('slug', $slug)->first();

            if (!empty($translation)) {
                $redirect = TypeTranslation::where('type_id', $translation->type_id)->where('locale', \App::getLocale())->first();

                if (empty($redirect)) {
                    return redirect()
                        ->route('index')
                        ->withErrors([
                            trans('types::front.type_not_found')
                        ]);
                }
                return redirect()->route('type.index', $redirect->slug);
            }
            return redirect()
                ->route('index')
                ->withErrors([
                    trans('types::front.type_not_found')
                ]);
        }

        $categories = $selected_type->categories->where('active',1);

        $available_categories = $categories->pluck('id')->toArray();

        $projects = Project::active()
            ->with(['media'])
            ->whereIn('category_id', $available_categories)
            ->reversed()
            ->paginate(self::$PER_PAGE);

        SEOMeta::setTitle(config('app.name', 'Mirage Visulisation') . ' - ' . $selected_type->title);
        SEOMeta::setDescription($selected_type->meta_description);
        SEOMeta::addKeyword(explode(', ', $selected_type->meta_keywords));
        OpenGraph::addImage(asset('/img/MV.png'), ['height' => 300, 'width' => 300]);

        return view('types::front.index', compact('selected_type', 'categories', 'projects'));
    }

    public function getProjects(Request $request)
    {
        $errors = [];

        if (empty($request->get('page'))) {
            $errors[] = trans('types::errors.no_page');
        }

        if (empty($request->get('category'))) {
            $errors[] = trans('types::errors.no_category');
        }

        if (empty($request->get('type'))) {
            $errors[] = trans('types::errors.no_type_selected');
        }

        $type_slug = $request->get('type');

        $type = Type::whereHas('translations', function ($query) use ($type_slug) {
            $query
                ->where('locale', \App::getLocale())
                ->where('slug', $type_slug);
        })->with(['categories'])->first();

        if ($request->get('category') == 'all') {
            $categories = $type->categories->where('active',1);
            $available_categories = $categories->pluck('id')->toArray();
        } else {
            $categories = $type->categories->where('active',1)->where('slug' , $request->get('category'));
            $available_categories = $categories->pluck('id')->toArray();
        }

        $projects = Project::active()
            ->with(['media'])
            ->whereIn('category_id', $available_categories)
            ->reversed()
            ->paginate(self::$PER_PAGE);


        return response()->json([
            'errors' => $errors,
            'projects_grid' => view('types::boxes.projects', compact('projects'))->render(),
        ]);

    }

}
