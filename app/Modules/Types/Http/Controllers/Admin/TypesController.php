<?php

namespace App\Modules\Types\Http\Controllers\Admin;

use App\Modules\Types\Forms\TypeForm;
use App\Modules\Types\Models\Type;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class TypesController extends BaseAdministrationController
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
        $table->query(Type::reversed()->withTrashed());
        $table->columns($columns);
        $table->addColumn('active', function ($category) {
            return AdministrationField::switch('active', $category);
        });
        $table->addColumn('action', function ($category) {
            $action = AdministrationField::edit(Administration::route('types.edit', $category->id));
            if ($category->trashed()) {
                $action .= AdministrationField::restore(Administration::route('types.destroy', $category->id));
            } else {
                $action .= AdministrationField::delete(Administration::route('types.destroy', $category->id));
            }
            return $action;
        });

        $table->smart(true);
        $table->filterColumn('title',  function($query, $keyword) {
            $query->whereHas('translations', function ($sub_q) use ($keyword) {
                $sub_q->where('title', 'LIKE', '%'. $keyword .'%');
            });
        });
        $table->rawColumns(['active', 'action']);

        Administration::setTitle(trans('types::admin.module_name') . ' - ' . trans('administration::admin.create'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('types::admin.module_name'), Administration::route('types.index'));
            $breadcrumbs->push(trans('administration::admin.view_all'));
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $type = new Type();

        $type->fill($request->all());
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
        $type = Type::withTrashed()->where('id', $id)->first();
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
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $model = Type::withTrashed()->where('id', $id)->first();

        $model->fill($request->all());
        $model->save();

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
        $model = Type::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
