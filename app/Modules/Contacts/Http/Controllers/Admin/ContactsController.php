<?php

namespace App\Modules\Contacts\Http\Controllers\Admin;

use App\Modules\Contacts\Forms\ContactForm;
use App\Modules\Contacts\Http\Requests\StoreContactRequest;
use App\Modules\Contacts\Models\Contact;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class ContactsController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return void
     */
    public function index(DataTables $datatable)
    {
        $columns = ['id', 'title', 'active', 'show_map', 'created_at', 'action'];
        $table = new AdministrationDatatable($datatable);
        $table->query(Contact::reversed());
        $table->columns($columns);
        $table->addColumn('active', function ($contact) {
            return AdministrationField::switch('active', $contact);
        });
        $table->addColumn('show_map', function ($contact) {
            return AdministrationField::switch('show_map', $contact);
        });
        $table->addColumn('action', function ($contact) {
            $action = AdministrationField::edit(Administration::route('contacts.edit', $contact->id));
            $action .= AdministrationField::delete(Administration::route('contacts.destroy', $contact->id));
            return $action;
        });

        $table->smart(true);
        $table->filterColumn('title',  function($query, $keyword) {
            $query->whereHas('translations', function ($sub_q) use ($keyword) {
                $sub_q->where('title', 'LIKE', '%'. $keyword .'%');
            });
        });
        $table->rawColumns(['active', 'show_map', 'action']);

        Administration::setTitle(trans('contacts::admin.module_name'));

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('contacts::admin.module_name'), Administration::route('contacts.index'));
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
        $form->route(Administration::route('contacts.store'));
        $form->form(ContactForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('contacts::admin.module_name'), Administration::route('contacts.index'));
            $breadcrumbs->push(trans('administration::admin.create'));
        });

        Administration::setTitle(trans('contacts::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContactRequest $request
     * @return void
     */
    public function store(StoreContactRequest $request)
    {
        $contact = new Contact();
        $data = $request->validated();
        $contact->fill($data);
        $contact->save();

        return redirect(Administration::route('contacts.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $contact = Contact::where('id', $id)->first();
        $form = new AdministrationForm();
        $form->route(Administration::route('contacts.update', $contact->id));
        $form->form(ContactForm::class);
        $form->model($contact);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('contacts::admin.module_name'), Administration::route('contacts.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('contacts::admin.module_name') . ' - ' . trans('administration::admin.edit'));

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreContactRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreContactRequest $request, $id)
    {
        $contact = Contact::where('id', $id)->first();
        $data = $request->validated();
        $contact->fill($data);
        $contact->save();

        return redirect(Administration::route('contacts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $model = Contact::where('id', $id)->first();
        $model->delete();
        return response()->json(['ok'], 200);
    }
}