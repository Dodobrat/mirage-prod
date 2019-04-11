<?php

namespace App\Modules\Types\Http\Controllers;

use App\Modules\Types\Models\Type;
use App\Http\Controllers\Controller;
use App\Modules\Types\Models\TypeTranslation;

class TypesController extends Controller
{
    public function index($slug)
    {
        $selected_type = Type::whereHas('translations', function ($query) use ($slug) {
            $query
                ->where('locale', \App::getLocale())
                ->where('slug', $slug);
        })->first();

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

        return view('types::front.index', compact('selected_type'));
    }
}