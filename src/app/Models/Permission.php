<?php

namespace processdrive\rap\Models;

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
        return $this->belongsToMany("processdrive\\rap\Models\Role","role_permission", "role_id", "permission_id");
    }

    /**
     * [rap_modules]
     * @return [type]
     */
    public function rap_modules() {
        return $this->belongsTo("processdrive\\rap\Models\\rap_modules","id", "module_id");
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
        return DB::table('modules')->where("name", "LIKE", "%{$search}%")->paginate(10);
    }
}
