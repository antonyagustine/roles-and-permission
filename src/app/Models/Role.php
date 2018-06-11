<?php

namespace processdrive\rap\app\Models;

use \processdrive\rap\app\Helpers\RAPHelper;


class Role extends Model
{
    public $table = 'roles';
    
    public $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
        'existing_role'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    private $role;
    
    // $action_array = array
    private $action_array;

    function __construct() {
        $this->action_array = RAPHelper::actionArrays();
    }

    /**
     * [getModules]
     * @return [array]
     */
    public function getModules()  {
        $modules_obj = new rap_modules();
        $this->role = new GetRoutes();
        $module_array = $this->role->getRouteAndModel('rap_modules');
        $modules = [];

        foreach ($modules_obj::get() as $key => $value) {
            $modules[$value->id] = $value->id > 1000 ?  $value->name : trans('rap_modules.'.$value->name);
        }

        return $modules;
    }

    /**
     * [getActions]
     * @return [array]
     */
    public function getActions($module_id) {
        $modules = rap_modules::whereId($module_id);
        $action_array['module_name'] = $modules->first();
        $action = $modules->with('permission')->get();
        
        foreach ($action[0]->permission as $key => $value) {
            $action_array[$value["id"]] = $value["action"];
        }

        return $action_array;
    }

    /**
     * [users]
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users() {
        return $this->belongsToMany("processdrive\\rap\app\Models\users", "user_role", "role_id", "user_id" );
    }

    /**
     * [permissions]
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function permissions() {
        return $this->belongsToMany("processdrive\\rap\app\Models\Permission", "role_permission", "role_id", "permission_id");
    }

    /**
     * [hasPermission]
     * @param  [str]  $action
     * @return boolean
     */
    public function hasPermission ($action) {
        return $this->belongsToMany("processdrive\\rap\app\Models\Permission","role_permission", "role_id", "permission_id")->whereAction($action)->first();
    }

    /**
     * [bindActions]
     * @param  [array] $data
     * @return [view]
     */
    public function bindActions($data) {
        $static_actions = array('index' => 'List', 'create' => 'Create', 'show' => 'Show', 'edit' => 'Edit', 'destroy' => 'Destroy', 'store' => 'Store', 'update' => 'Update', 'delete' => 'Delete');
        $button = '<button type="submit" class="pull-right btn-md btn btn-primary">Save</button>';
        $role = static::whereId($data['role_id'])->first();

        if (!empty($data['module_id'])) {
            $i = 0;
            echo '<script type="text/javascript">
                    $("input").iCheck({
                        checkboxClass: "icheckbox_square-blue",
                        increaseArea: "20%", // optional
                    });
                  </script>';
            echo '<div class="panel panel-primary"> <div class="panel-body">'.$button.'<table> <tr> <th>Module</th> <th>Action</th> </tr>';

            foreach ($data['module_id'] as $key => $value) {
                $actions =  static::getActions($value);

                if ($key == $i) {
                    $moduleName = ($actions['module_name']->id > 1000) ? $actions['module_name']->name : trans('rap_modules.'.$actions['module_name']->name);
                    echo '<tr> <td colspan="2" class="module_name"><label class="col-sm-10">'.$moduleName.'</label> <label class="col-sm-1"> Check All </label> <input type="checkbox" name="check-all" class="permission col-sm-1 check-all" data-child-class="'.$i.'"> </td></tr>';
                }

                foreach ($actions as $action_key => $action_value) {
                    $action = explode('.', $action_value);
                    $checked = ($role->hasPermission($action_value)) ? "checked" : "";

                    if ($action_key !== 'module_name' && !empty(end($action))) {
                    
                        if (@$this->action_array['static_actions'][end($action)])
                        $trans = trans('rap_actions.'.end($action));
                        else
                        $trans = trans('rap_actions.'.$action_value);

                        $trans = ($actions['module_name']->id > 1000) ? $action_value: $trans;

                        if($action_key >= '2001')
                        $trans = str_replace('.', ' ', $action_value);

                        echo '<tr> <td><label>'.$trans.'</label></td> <td> <input type="checkbox" '.$checked.' name="'.$action_value.'" class="permission '.$i.'"> </td> </tr>';
                    }
                }
                $i++;
            }
            echo '</table>'.$button.'</div></div>';
        }
    }

    /**
     * [getDataForIndex]
     * @param  [boolean || str] $search
     * @return [array]
     */
    public function getDataForIndex($search)  {
        return static::where('deleted_at', null)->where("name", "LIKE", "%{$search}%")->paginate(3);
    }
}