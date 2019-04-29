<?php

namespace App\Modules\Workflow\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Workflow\Models\Workflow;
use App\Modules\Workflow\Models\WorkflowTranslation;
use Illuminate\Http\Request;

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

    public function getWorkflow(Request $request) {

        $errors = [];

        if (empty($request->get('workflow_id'))) {
            $errors[] = trans('index::errors.no_workflow_selected');
        }

        $workflow = Workflow::where('id', $request->workflow_id)->first();

        if (empty($workflow)) {
            $errors[] = trans('index::errors.no_workflow');
        }

        if (empty($errors) && $request->get('access_key') == $workflow->access_key){

            session([
                'access_key' => $request->get('access_key'),
                'workflow_slug' => $request->get('workflow_slug'),
            ]);

        } else {
            $errors[] = trans('index::errors.wrong_access_key');
        }

        return response()->json([
            'errors' => $errors,
            'workflow_content' => view('workflow::boxes.workflow_content', compact('workflow'))->render(),
        ]);
    }
}
