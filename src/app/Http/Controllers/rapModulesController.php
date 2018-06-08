<?php

namespace processdrive\rap\Http\Controllers;

use processdrive\rap\Models\Permission;
use \App\Http\Controllers\Controller;

class rapModulesController extends Controller
{
    protected $permission;

    function __construct() {
        $this->permission = new Permission();
    }

    /**
     * Display a listing of the specialPermission.
     *
     * @param specialPermissionDataTable $specialPermissionDataTable
     * @return Response
     */
    public function index($search = '')
    {
        $data = $this->permission->getDataForIndex($search);

        return view('rap::rap_modules.index', compact('data', 'search', 'msg'));
    }

    /**
     * [createPermission]
     * @param  [int] $id
     * @return [void]
     */
    public function createPermission($module_id, $search = '') {
        $module = $this->permission->where('module_id', '=', $module_id)->pluck('action', 'id')->first();
        $data = $this->renderAction($module_id, $search);

        return view('rap::rap_modules.actions', compact('module_id', 'module', 'data', 'search'));
    }

    /**
     * [renderAction]
     * @param  [int] $id
     * @return [array]
     */
    public function renderAction($module_id, $search) {
        return $this->permission->select('permissions.*')->whereModule_id($module_id)->where('id', '>', 2000)->where("action", "LIKE", "%{$search}%")->paginate(10);
    }

    /**
     * [saveAction]
     * @return [array || str]
     */
    public function saveAction() {
        $this->permission->createOrUpdate(request()->all());
    }

    /**
     * [editAction]
     * @param  [int] $id
     * @return [array]
     */
    public function editAction() {
        $request = request()->all();
        return $this->permission->whereId($request['id'])->whereModule_id($request['module_id'])->get();
    }

    /**
     * [deleteAction ]
     * @return [bool]
     */
    public function deleteAction() {
        return $this->permission->where('id', request()->get('id'))->delete();
    }
}
