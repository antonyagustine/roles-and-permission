<?php

namespace processdrive\rap\app\Models;

use Illuminate\Database\Eloquent\Model;

class rap_modules extends Model
{
    public $table = 'modules';

    protected $fillable = ["name", "id"];

    /**
     * [permission]
     * @return [type]
     */
    public function permission() {
        return $this->hasMany("processdrive\\rap\app\Models\Permission", "module_id", "id");
    }
}
