<?php

namespace App\Modules\Team\Http\Controllers\Admin;

use App\Modules\Team\Forms\MemberForm;
use App\Modules\Team\Http\Requests\StoreMemberRequest;
use App\Modules\Team\Models\Member;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class TeamController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return Response
     */
    public function index(DataTables $datatable)
    {
        $columns = ['id', 'name','position', 'active', 'created_at', 'action'];
        $table = new AdministrationDatatable($datatable);
        $table->query(Member::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('position', function ($member) {
            return $member->position;
        });
        $table->addColumn('active', function ($member) {
            return AdministrationField::switch('active', $member);
        });
        $table->addColumn('action', function ($member) {
            $action = AdministrationField::edit(Administration::route('team.edit', $member->id));
            if (!empty($member->deleted_at)) {
                $action .= AdministrationField::restore(Administration::route('team.destroy', $member->id));
            }
            else{
                $action .= AdministrationField::delete(Administration::route('team.destroy', $member->id));
            }
            $action .= AdministrationField::media($member, ['photo']);
            return $action;
        });

        $table->smart(true);
        $table->filterColumn('name',  function($query, $keyword) {
            $query->whereHas('translations', function ($sub_q) use ($keyword) {
                $sub_q->where('name', 'LIKE', '%'. $keyword .'%');
            });
        });
        $table->rawColumns(['active', 'action']);

        Administration::setTitle(trans('team::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('team::admin.module_name'), Administration::route('team.index'));
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
        $form->route(Administration::route('team.store'));
        $form->form(MemberForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('team::admin.module_name'), Administration::route('team.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('team::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMemberRequest $request
     * @return Response
     */
    public function store(StoreMemberRequest $request)
    {
        $data = $request->validated();
        $member = new Member();
        $member->fill($data);
        $member->save();

        return redirect(Administration::route('team.index'))->withSuccess([trans('index::admin.success_create')]);
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
        $member = Member::withTrashed()->where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('team.update', $member->id));
        $form->form(MemberForm::class);
        $form->model($member);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('team::admin.module_name'), Administration::route('team.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('team::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreMemberRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreMemberRequest $request, $id)
    {
        $member = Member::where('id', $id)->first();
        $data = $request->validated();
        $member->fill($data);
        $member->save();

        return redirect(Administration::route('team.index'))->withSuccess([trans('index::admin.success_updated')]);
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
        $model = Member::withTrashed()->where('id', $id)->first();
        if ($model->trashed()) {
            $model->restore();
        } else {
            $model->delete();
        }
        return response()->json(['ok'], 200);
    }
}
