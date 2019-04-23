<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Workflow\Models\Workflow;
use App\Modules\Workflow\Models\WorkflowTranslation;

class WorkflowController extends Controller
{

    public function index($slug){

        $accessed_workflow = Workflow::whereHas('translations', function ($query) use ($slug) {
            $query
                ->where('locale', \App::getLocale())
                ->where('slug', $slug);
        })->first();

        if (empty($accessed_workflow)) {
            $translation = WorkflowTranslation::where('slug', $slug)->first();

            if (!empty($translation)) {
                $redirect = WorkflowTranslation::where('workflow_id', $translation->workflow_id)->where('locale', \App::getLocale())->first();

                if (empty($redirect)) {
                    return redirect()
                        ->route('index')
                        ->withErrors([
                            trans('workflow::front.workflow_not_found')
                        ]);
                }
                return redirect()->route('workflow.index', $redirect->slug);
            }
            return redirect()
                ->route('index')
                ->withErrors([
                    trans('workflow::front.workflow_not_found')
                ]);
        }

        return view('workflow::front.view', compact('accessed_workflow'));

    }
}
