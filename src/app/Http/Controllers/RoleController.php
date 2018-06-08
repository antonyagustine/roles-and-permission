<?php

namespace processdrive\rap\Http\Controllers;

use \App\Http\Controllers\AppBaseController;
use processdrive\rap\Helpers\RAPHelper;
use \App\Http\Controllers\Controller;
use \processdrive\rap\Models\Role;

class RoleController extends Controller
{
    /** @var  RoleRepository */
    private $roleModel;

    public function __construct(Role $role)
    {
        session_start();
        $this->roleModel = $role;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return Response
     */
    public function index($search = '')
    {
        $msg = RAPHelper::getFlash();
        $data = $this->roleModel->getDataForIndex($search);

        return view('rap::roles.index', compact('data', 'search', 'msg'));
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        $roles = $this->roleModel->where('deleted_at', null)->pluck('name', 'id')->toArray();
        return view('rap::roles.create_or_edit', compact('roles'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store()
    {
        $input = request()->except("_token");
        $this->createOrUpdate($input);
        $_SESSION['key'] = 'store';

        return redirect(route('rap', 'roles.index'));
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleModel->findOrFail($id);
        $roles = $this->roleModel->whereNotIn('id', [$id])->where('deleted_at', null)->pluck('name', 'id')->toArray();

        if (empty($role)) {
            $_SESSION['key'] = 'error';

            return redirect(route('rap', 'roles.index'));
        }

        return view('rap::roles.create_or_edit')->with(array_merge(compact('role'), compact('roles')));
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int              $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id)
    {
        $role = $this->roleModel->findOrFail($id);
        if (empty($role)) {
            $_SESSION['key'] = 'error';

            return redirect(route('rap', 'roles.index'));
        }

        $this->createOrUpdate(request()->all(), $id);
        $_SESSION['key'] = 'update';

        return redirect(route('rap', 'roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleModel->findOrFail($id);

        if (empty($role)) {
            $_SESSION['key'] = 'error';
            return redirect(route('rap', 'roles.index'));
        }

        $role->permissions()->detach();
        $role->delete($id);
        $_SESSION['key'] = 'destroy';

        return redirect(route('rap', 'roles.index'));
    }

    /**
     * [assignPermission]
     * @param  [type] $id
     * @return [array / blade]
     */
    public function assignPermission($id) {
        $modules = $this->roleModel->getModules();
        return view('rap::roles_and_permission.assign_roles_and_permission')->with(['id' => $id, 'modules' => $modules]);
    }

    /**
     * [getActionForRAP]
     * @return [array]
     */
    public function getActionForRAP()  {
        $this->roleModel->bindActions(request()->all());
    }

    /**
     * [saveRAP]
     * @return [void]
     */
    public function saveRAP() {
        $request = request()->all();
        $role = $this->roleModel->whereId($request["role_id"])->first();
        unset($request["role_id"]);

        foreach ($request as $key => $value) {
            $permission = \processdrive\rap\Models\Permission::whereAction(str_replace("_", ".", $key) )->first();
            if ($value)
            $role->permissions()->attach($permission);
            else if (@$permission)
            $role->permissions()->detach($permission);
        }
    }

    /**
     * [createOrUpdate]
     * @param  [array] $input
     * @param  [int] $id
     * @return [void]
     */
    private function createOrUpdate($input, $id = NULL) {
        $templateRole = $this->roleModel->whereId(@$input["existing_role"])->first();
        $role = $this->roleModel->updateOrCreate(['id' => $id], $input);
        $role->permissions()->detach();

        if (@$templateRole) {
            foreach ( $templateRole->permissions()->get() as $permission) {
                $role->permissions()->attach($permission);
            }
        }
    }
}
