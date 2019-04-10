<?php

namespace App\Modules\Types\Http\Controllers\Admin;

use App\Modules\Types\Forms\TypeForm;
use App\Modules\Types\Models\Type;
use App\Modules\Types\Http\Requests\StoreTypeRequest;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class TypesController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return void
     */
    public function index(DataTables $datatable)
    {
        $columns = ['id', 'title', 'active', 'created_at', 'action'];
        $table = new AdministrationDatatable($datatable);
        $table->query(Type::reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($type) {
            return AdministrationField::switch('active', $type);
        });
        $table->addColumn('action', function ($type) {
            $action = AdministrationField::edit(Administration::route('types.edit', $type->id));
            $action .= AdministrationField::delete(Administration::route('types.destroy', $type->id));
            return $action;
        });

        $table->smart(true);
        $table->filterColumn('title',  function($query, $keyword) {
            $query->whereHas('translations', function ($sub_q) use ($keyword) {
                $sub_q->where('title', 'LIKE', '%'. $keyword .'%');
            });
        });
        $table->rawColumns(['active', 'action']);

        Administration::setTitle(trans('types::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
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
        $form->route(Administration::route('types.store'));
        $form->form(TypeForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('types::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTypeRequest $request
     * @return void
     */
    public function store(StoreTypeRequest $request)
    {
        $data = $request->validated();
        $type = new Type();
        $type->fill($data);
        $type->save();

        return redirect(Administration::route('types.index'));
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
        $type = Type::where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('types.update', $type->id));
        $form->form(TypeForm::class);
        $form->model($type);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('types::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreTypeRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreTypeRequest $request, $id)
    {
        $type = Type::where('id', $id)->first();
        $data = $request->validated();
        $type->fill($data);
        $type->save();

        return redirect(Administration::route('types.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $model = Type::where('id', $id)->first();
        $model->delete();
        return response()->json(['ok'], 200);
    }
}
