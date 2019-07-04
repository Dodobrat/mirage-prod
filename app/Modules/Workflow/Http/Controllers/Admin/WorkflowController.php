<?php

namespace App\Modules\Workflow\Http\Controllers\Admin;

use App\Modules\Workflow\Forms\WorkflowForm;
use App\Modules\Workflow\Http\Requests\StoreWorkflowRequest;
use App\Modules\Workflow\Models\Workflow;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Helpers\Dashboard;
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
            $action .= AdministrationField::media($flow, ['access','comic']);
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
        $dashboard = new Dashboard();

        $dashboard->custom('
        <style>
        .password-generator-btn{
            border:none;
            border-radius: 3px;
            padding: 10px; 
        }.pass{
            display: none;
            padding: 20px 20px 0 0;
            font-size: 16px;
            margin: 0;
        }.pass:hover{
            cursor:pointer;
        }.copied{
            z-index: 10000;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 2px;
            padding: 20px 25px;
        }
        </style>
        
        <div class="col-sm-12">
            <div class="white-box" style="margin-bottom: 0;">
                <div class="password-generator-container">
                    <button class="password-generator-btn bg-danger text-white">'. trans('workflow::admin.generate_access_key') .'</button>
                    <p class="pass"></p>
                </div>
                <div class="copied text-muted"><h2>'. trans('workflow::admin.copied') .'</h2></div>
            </div>
        </div>
        
        <script>
            let pass = document.querySelector(\'.pass\');
            let btn = document.querySelector(\'.password-generator-btn\');
            btn.addEventListener(\'click\', function(){
            let length = 30,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_/!&",
                    retVal = "";
                for (let i = 0, n = charset.length; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * n));
                }
                pass.style.display = "block";
                pass.innerHTML = retVal;
            });
            pass.onclick = function() {
                document.execCommand("copy");
            };
            pass.addEventListener("copy", function(event) {
                event.preventDefault();
                if (event.clipboardData) {
                    event.clipboardData.setData("text/plain", pass.textContent);
                    $(".copied").slideDown(200);
                    setTimeout(function(){
                        $(".copied").slideUp(300);
                    }, 3000);
                }
            });
        </script>
        ');

        $dashboard->generate();

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
        $dashboard = new Dashboard();

        $dashboard->custom('
        <style>
        .password-generator-btn{
            border:none;
            border-radius: 3px;
            padding: 10px; 
        }.pass{
            display: none;
            padding: 20px 20px 0 0;
            font-size: 16px;
            margin: 0;
        }.pass:hover{
            cursor:pointer;
        }.copied{
            z-index: 10000;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 2px;
            padding: 20px 25px;
        }
        </style>
        
        <div class="col-sm-12">
            <div class="white-box" style="margin-bottom: 0;">
                <div class="password-generator-container">
                    <button class="password-generator-btn bg-danger text-white">'. trans('workflow::admin.generate_access_key') .'</button>
                    <p class="pass"></p>
                </div>
                <div class="copied text-muted"><h2>'. trans('workflow::admin.copied') .'</h2></div>
            </div>
        </div>
        
        <script>
            let pass = document.querySelector(\'.pass\');
            let btn = document.querySelector(\'.password-generator-btn\');
            btn.addEventListener(\'click\', function(){
            let length = 30,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_/!&",
                    retVal = "";
                for (let i = 0, n = charset.length; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * n));
                }
                pass.style.display = "block";
                pass.innerHTML = retVal;
            });
            pass.onclick = function() {
                document.execCommand("copy");
            };
            pass.addEventListener("copy", function(event) {
                event.preventDefault();
                if (event.clipboardData) {
                    event.clipboardData.setData("text/plain", pass.textContent);
                    $(".copied").slideDown(200);
                    setTimeout(function(){
                        $(".copied").slideUp(300);
                    }, 3000);
                }
            });
        </script>
        ');

        $dashboard->generate();

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
