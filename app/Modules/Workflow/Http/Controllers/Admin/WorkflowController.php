<?php

namespace App\Modules\Workflow\Http\Controllers\Admin;

use App\Modules\Workflow\Forms\WorkflowForm;
use App\Modules\Workflow\Http\Requests\StoreWorkflowRequest;
use App\Modules\Workflow\Models\Workflow;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class WorkflowController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return Response
     */
    public function index(DataTables $datatable)
    {
        $columns = ['id', 'title', 'active', 'created_at', 'action'];
        $table = new AdministrationDatatable($datatable);
        $table->query(Workflow::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($flow) {
            return AdministrationField::switch('active', $flow);
        });
        $table->addColumn('action', function ($flow) {
            $action = AdministrationField::edit(Administration::route('workflow.edit', $flow->id));
            if (!empty($flow->deleted_at)) {
                $action .= AdministrationField::restore(Administration::route('workflow.destroy', $flow->id));
            }
            else{
                $action .= AdministrationField::delete(Administration::route('workflow.destroy', $flow->id));
            }
            $action .= AdministrationField::media($flow, ['access']);
            return $action;
        });

        $table->smart(true);
        $table->filterColumn('title',  function($query, $keyword) {
            $query->whereHas('translations', function ($sub_q) use ($keyword) {
                $sub_q->where('title', 'LIKE', '%'. $keyword .'%');
            });
        });
        $table->rawColumns(['active', 'action']);

        Administration::setTitle(trans('workflow::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('workflow::admin.module_name'), Administration::route('workflow.index'));
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
        $form->route(Administration::route('workflow.store'));
        $form->form(WorkflowForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('workflow::admin.module_name'), Administration::route('workflow.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('workflow::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkflowRequest $request
     * @return Response
     */
    public function store(StoreWorkflowRequest $request)
    {
        $data = $request->validated();
        $type = new Workflow();
        $type->fill($data);
        $type->save();

        return redirect(Administration::route('workflow.index'))->withSuccess([trans('index::admin.success_create')]);
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
        $flow = Workflow::withTrashed()->where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('workflow.update', $flow->id));
        $form->form(WorkflowForm::class);
        $form->model($flow);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('workflow::admin.module_name'), Administration::route('workflow.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('workflow::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreWorkflowRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreWorkflowRequest $request, $id)
    {
        $flow = Workflow::where('id', $id)->first();
        $data = $request->validated();
        $flow->fill($data);
        $flow->save();

        return redirect(Administration::route('workflow.index'))->withSuccess([trans('index::admin.success_updated')]);
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
        $model = Workflow::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
