<?php

namespace App\Modules\Projects\Http\Controllers\Admin;

use App\Modules\Projects\Forms\ProjectForm;
use App\Modules\Projects\Http\Requests\StoreProjectRequest;
use App\Modules\Projects\Models\Project;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class ProjectsController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return Response
     */
    public function index(DataTables $datatable)
    {
        $columns = ['id', 'title', 'architect', 'category', 'active', 'created_at', 'action'];
        $table = new AdministrationDatatable($datatable);
        $table->query(Project::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($project) {
            return AdministrationField::switch('active', $project);
        });
        $table->addColumn('category', function ($project) {
            return $project->category->title;
        });
        $table->addColumn('action', function ($project) {
            $action = AdministrationField::edit(Administration::route('projects.edit', $project->id));
            if (!empty($project->deleted_at)) {
                $action .= AdministrationField::restore(Administration::route('projects.destroy', $project->id));
            }
            else{
                $action .= AdministrationField::delete(Administration::route('projects.destroy', $project->id));
            }
            $action .= AdministrationField::media($project, ['media']);
            return $action;
        });

        $table->smart(true);
        $table->filterColumn('title',  function($query, $keyword) {
            $query->whereHas('translations', function ($sub_q) use ($keyword) {
                $sub_q->where('title', 'LIKE', '%'. $keyword .'%');
            });
        });
        $table->rawColumns(['active', 'action']);

        Administration::setTitle(trans('projects::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('projects::admin.module_name'), Administration::route('projects.index'));
        });

        return $table->generate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = new AdministrationForm();
        $form->route(Administration::route('projects.store'));
        $form->form(ProjectForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('projects::admin.module_name'), Administration::route('projects.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('projects::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $project = new Project();
        $project->fill($data);
        $project->save();

        return redirect(Administration::route('projects.index'))->withSuccess([trans('index::admin.success_create')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $project = Project::withTrashed()->where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('projects.update', $project->id));
        $form->form(ProjectForm::class);
        $form->model($project);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('projects::admin.module_name'), Administration::route('projects.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('projects::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreProjectRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreProjectRequest $request, $id)
    {
        $project = Project::where('id', $id)->first();
        $data = $request->validated();
        $project->fill($data);
        $project->save();

        return redirect(Administration::route('projects.index'))->withSuccess([trans('index::admin.success_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = Project::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
