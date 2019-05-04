<?php

namespace App\Modules\Types\Http\Controllers;

use App\Modules\Projects\Models\Project;
use App\Modules\Types\Models\Type;
use App\Http\Controllers\Controller;
use App\Modules\Types\Models\TypeTranslation;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    private static $PER_PAGE = 2;

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

        $available_categories = $selected_type->categories->pluck('id')->toArray();

        $projects = Project::active()
            ->with(['media'])
            ->whereIn('category_id', $available_categories)
            ->reversed()
            ->paginate(self::$PER_PAGE);

        return view('types::front.index', compact('selected_type', 'projects'));
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
            $available_categories = $type->categories->pluck('id')->toArray();
        } else {
            $available_categories = $type->categories->where('slug', $request->get('category'))->pluck('id')->toArray();
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
