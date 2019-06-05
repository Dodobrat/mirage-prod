<?php

namespace App\Modules\Categories\Http\Controllers\Admin;

use App\Modules\Categories\Http\Requests\StoreCategoryRequest;
use App\Modules\Categories\Models\Category;
use App\Modules\Categories\Forms\CategoryForm;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class CategoriesController extends BaseAdministrationController
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
        $table->query(Category::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($category) {
            return AdministrationField::switch('active', $category);
        });
        $table->addColumn('action', function ($category) {
            $action = AdministrationField::edit(Administration::route('categories.edit', $category->id));
            if (!empty($category->deleted_at)) {
                $action .= AdministrationField::restore(Administration::route('categories.destroy', $category->id));
            }
            else{
                $action .= AdministrationField::delete(Administration::route('categories.destroy', $category->id));
            }
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

        Administration::setTitle(trans('categories::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('categories::admin.module_name'), Administration::route('categories.index'));
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
        $form->route(Administration::route('categories.store'));
        $form->form(CategoryForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('categories::admin.module_name'), Administration::route('categories.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('categories::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = new Category();
        $category->fill($data);
        $category->save();

        return redirect(Administration::route('categories.index'))->withSuccess([trans('index::admin.success_create')]);
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
        $category = Category::withTrashed()->where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('categories.update', $category->id));
        $form->form(CategoryForm::class);
        $form->model($category);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('categories::admin.module_name'), Administration::route('categories.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('categories::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $category = Category::where('id', $id)->first();
        $data = $request->validated();
        $category->fill($data);
        $category->save();

        return redirect(Administration::route('categories.index'))->withSuccess([trans('index::admin.success_updated')]);
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
        $model = Category::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
