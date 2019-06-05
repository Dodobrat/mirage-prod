<?php

namespace App\Modules\Index\Http\Controllers\Admin;

use App\Modules\Index\Forms\IndexForm;
use App\Modules\Index\Http\Requests\StoreIndexRequest;
use App\Modules\Index\Models\Index;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class IndexController extends BaseAdministrationController
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
        $table->query(Index::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($index) {
            return AdministrationField::switch('active', $index);
        });
        $table->addColumn('action', function ($index) {
            $action = AdministrationField::edit(Administration::route('index.edit', $index->id));
            if (!empty($index->deleted_at)) {
                $action .= AdministrationField::restore(Administration::route('index.destroy', $index->id));
            }
            else{
                $action .= AdministrationField::delete(Administration::route('index.destroy', $index->id));
            }
            $action .= AdministrationField::media($index, ['background','filter','grid']);
            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {
            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });
            }
        });

        $table->rawColumns(['active', 'action']);

        Administration::setTitle(trans('index::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('index::admin.module_name'), Administration::route('index.index'));
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
        $form->route(Administration::route('index.store'));
        $form->form(IndexForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('index::admin.module_name'), Administration::route('index.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('index::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIndexRequest $request
     * @return void
     */
    public function store(StoreIndexRequest $request)
    {
        $index = new Index();
        $data = $request->validated();
        $index->fill($data);
        $index->save();

        return redirect(Administration::route('index.index'))->withSuccess([trans('index::admin.success_create')]);
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
        $index = Index::withTrashed()->where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('index.update', $index->id));
        $form->form(IndexForm::class);
        $form->model($index);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('index::admin.module_name'), Administration::route('index.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('index::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreIndexRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreIndexRequest $request, $id)
    {
        $index = Index::where('id', $id)->first();
        $data = $request->validated();
        $index->fill($data);
        $index->save();

        return redirect(Administration::route('index.index'))->withSuccess([trans('index::admin.success_updated')]);
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
        $model = Index::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
