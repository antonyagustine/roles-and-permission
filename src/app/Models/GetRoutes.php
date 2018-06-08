<?php

namespace processdrive\rap\app\Models;

use \processdrive\rap\app\Helpers\RAPHelper;

class GetRoutes extends Model
{
    private $action_array;

    function __construct() {
        $this->action_array = RAPHelper::actionArrays();
    }

    /**
     * [createTransFiles]
     * @return [void]
     */
    public function createTransFiles() {
        $files_array = array('1' => 'rap_actions', '2' => 'rap_modules');

        foreach ($files_array as $key => $value) {
            $trans_array = $this->getRouteAndModel($value);
            $this->constructTransFile($value, $trans_array);
        }
        $this->writeIntoPermissionTable();
    }

    /**
     * [constructTransFile]
     * @param  [str] $file_name
     * @param  [array] $trans
     * @return [void]
     */
    public function constructTransFile($file_name, $trans) {
        $path = resource_path('lang/en/'.$file_name.'.php');
        $content = $this->constructTransArray($path, $trans);
        $this->writeIntoTransFile($path, $content);
    }

    /**
     * [createTransFile]
     * @param  [array] $modules
     * @return [void]
     */
    public function constructTransArray($path, $trans) {
        $trans_array = '<?php'.PHP_EOL."\t".'return ['.PHP_EOL;
        $old = is_file($path) ? include $path : '';

        foreach ($trans as $key => $value) {
            $status = true;
            if (!empty($old)) {
                foreach ($old as $o_key => $o_string) {
                    if($o_key == $key) {
                        $status = false;
                        $trans_array .= "\t\t".'"'.$o_key.'" => "'.$o_string.'",'.PHP_EOL;
                        break;
                    } 
                }
                     
                if ($status)
                $trans_array .= "\t\t".'"'.$key.'" => "'.$value.'",'.PHP_EOL;    
            }

            if (empty($old))
            $trans_array .= "\t\t".'"'.$key.'" => "'.$value.'",'.PHP_EOL;    
        }
        $trans_array .= "\t".'];';

        return $trans_array;
    }

    /**
     * [writeIntoTransFile]
     * @param  [str] $path
     * @param  [str] $content
     * @return [void]
     */
    public function writeIntoTransFile($path, $content) {
        $file_path = fopen($path, 'w');
        fwrite($file_path, $content);
        fclose($file_path);
    }

    /**
     * [writeIntoPermissionTable]
     * @return [void]
     */
    public function writeIntoPermissionTable()  {
        $permission = new \processdrive\rap\app\Models\Permission();
        $modules = new \processdrive\rap\app\Models\rap_modules();
        $route_array = $this->getDataForPermissionTableSeeding();
        $pre_module = "";

        foreach ($route_array as $action => $module) {
            if ($module != $pre_module) {
                $id = $modules::where("id", "<", 1000)->max("id");
                $id = (@$id) ? $id + 1 : 1;
                $module = $modules::firstOrNew(['name' => $module]);
                
                if (@$module->id) {
                    $module_id = $module->id;
                } else {
                    $module_id = $module->id = @$module->id ?  $module->id : $id;
                    $module->save();
                }
                $pre_module = $module;  
            }

            $id = $permission::where("id", "<", 2000)->max("id");
            $id = (@$id) ? $id + 1 : 1;
            $permission = $permission::firstOrNew(['action' => @$action]);

            if (!@$permission->id) {
                $permission->id = $id;
                $permission->module_id = $module_id;
                $permission->save();
            }
        }
    }

    /**
     * [getDataForPermissionTableSeeding]
     * @return [void]
     */
    public function getDataForPermissionTableSeeding() {
        $obj = new \processdrive\rap\app\Models\GetRoutes();
        $route = $obj->getRouteAndModel('route');
        $module_trans_arrray = [];

        foreach ($route as $key => $value) {
            $name = explode(".", @$value);
            if(@$name[2] && !empty(end($name)))
            $module_trans_arrray[$name[0].'.'.$name[1].'.'.$name[2]] = $name[0].'.'.$name[1];

            if (!@$name[2] && !empty(@$name[1]))
            $module_trans_arrray[$name[0].'.'.$name[1]] = $name[0];
            
            if (empty(@$name[1]))
            $module_trans_arrray[$name[0]] = $name[0];
        }

        return $module_trans_arrray;
    }

    /**
     * [getRouteAndModel]
     * @param  [boolean (or) str] $param
     * @return [array]
     */
    public function getRouteAndModel($param = false) {
        $raw_data = [];
        $module_trans_arrray = [];
        $action_trans_arrray = [];

        foreach (app('router')->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $name = explode(".", $action['as']);
                if (!@$this->action_array['omit_action'][@$name[0]] && !@$this->action_array['omit_action'][@$name[1]] && !@$this->action_array['omit_action'][@$name[2]]) {
                    $raw_data[] = $action['as'];
                
                    if(@$name[2])
                    $module_trans_arrray[$name[0].'.'.$name[1]] = $name[0].'.'.$name[1];

                    if (!@$name[2])
                    $module_trans_arrray[$name[0]] = $name[0];

                    if (!@$this->action_array['static_actions'][@$name[1]]) {
                        if (!@$name[2] && !empty(@$name[1]))
                        $action_trans_arrray[$name[0].'.'.$name[1]] = $name[1];
                        if (!empty(@$name[2]))
                        $action_trans_arrray[$name[0].'.'.$name[1].'.'.$name[2]] = $name[2];
                        if (empty(@$name[1]))
                        $action_trans_arrray[$name[0]] = $name[0];
                    }
                }
            }
        }

        switch ($param) {
            case 'rap_actions':
                $result = array_merge(@$this->action_array['static_actions'], $action_trans_arrray);
                break;
            case 'rap_modules':
                $result = $module_trans_arrray;
                break;
            case 'route':
                $result = $raw_data;
                break;
            default:
                $result = null;
                break;
        }

        return $result;
    }
}