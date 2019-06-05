<?php

namespace App\Modules\Blocks\Http\Controllers\Admin;

use App\Modules\Blocks\Http\Requests\StoreBlockRequest;
use App\Modules\Blocks\Models\Block;
use App\Modules\Blocks\Forms\BlockForm;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class BlocksController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return Response
     */
    public function index(DataTables $datatable)
    {
        $columns = ['id', 'key', 'active', 'created_at', 'action'];
        $table = new AdministrationDatatable($datatable);
        $table->query(Block::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($block) {
            return AdministrationField::switch('active', $block);
        });
        $table->addColumn('action', function ($block) {
            $action = AdministrationField::edit(Administration::route('blocks.edit', $block->id));
            if (!empty($block->deleted_at)) {
                $action .= AdministrationField::restore(Administration::route('blocks.destroy', $block->id));
            }
            else{
                $action .= AdministrationField::delete(Administration::route('blocks.destroy', $block->id));
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

        Administration::setTitle(trans('blocks::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blocks::admin.module_name'), Administration::route('blocks.index'));
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
        $form->route(Administration::route('blocks.store'));
        $form->form(BlockForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blocks::admin.module_name'), Administration::route('blocks.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('blocks::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBlockRequest $request
     * @return void
     */
    public function store(StoreBlockRequest $request)
    {
        $block = new Block();
        $data = $request->validated();
        $block->fill($data);
        $block->save();

        return redirect(Administration::route('blocks.index'))->withSuccess([trans('index::admin.success_create')]);
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
        $block = Block::withTrashed()->where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('blocks.update', $block->id));
        $form->form(BlockForm::class);
        $form->model($block);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blocks::admin.module_name'), Administration::route('blocks.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('blocks::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreBlockRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreBlockRequest $request, $id)
    {
        $block = Block::where('id', $id)->first();
        $data = $request->validated();
        $block->fill($data);
        $block->save();

        return redirect(Administration::route('blocks.index'))->withSuccess([trans('index::admin.success_updated')]);
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
        $model = Block::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
