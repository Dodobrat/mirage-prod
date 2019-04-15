<?php

namespace App\Modules\Projects\Http\Controllers;

use App\Modules\Projects\Models\Project;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    public function getProject(Request $request) {

        $errors = [];

        if (empty($request->get('project_id'))) {
            $errors[] = trans('index::errors.no_projects');
        }

        $project = Project::with(['media'])->where('id', $request->project_id)->first();

        if (empty($project)) {
            $errors[] = trans('index::errors.no_project');
        }

        return response()->json([
            'errors' => $errors,
            'project_modal' => view('projects::front.boxes.project', compact('project'))->render(),
        ]);
    }
}
