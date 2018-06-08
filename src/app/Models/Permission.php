<?php

namespace processdrive\rap\app\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Permission extends Model
{
	public $table = 'permissions';

	protected $fillable = ['id', 'action', 'module_id'];

    /**
     * [roles]
     * @return [type]
     */
	public function roles() {
        return $this->belongsToMany("processdrive\\rap\app\Models\Role","role_permission", "role_id", "permission_id");
    }

    /**
     * [rap_modules]
     * @return [type]
     */
    public function rap_modules() {
        return $this->belongsTo("processdrive\\rap\app\Models\\rap_modules","id", "module_id");
    }

    /**
     * [createOrUpdate]
     * @param  [str]  $data
     * @param  [boolean || int] $id
     * @return [array]
     */
    public function createOrUpdate($data)  {
    	$id = DB::table('permissions')->max('id');
        
        if (!$data['id'])
        $data['id'] = (@$id > 2000) ? $id += 1 : 2001;

        return static::updateOrCreate(['id' => $data['id']], $data);
    }

    /**
     * [getDataForIndex]
     * @return [array]
     */
    public function getDataForIndex($search)  {
        $trans = include resource_path('lang/en/rap_modules.php');
        $query = DB::table('modules');
        $st = false;

        if (@$search) {
            foreach ($trans as $key => $value) {
                if (strpos(strtolower($value), strtolower($search)) !== false) {
                    if (!$st) {
                        $query->whereName($key);    
                        $st = true;
                    } else {
                        $query->orWhere("name", '=', $key);    
                    }
                }
            }
        }
        
        return $query->paginate(10);
    }
}