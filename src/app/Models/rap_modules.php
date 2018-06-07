<?php

namespace processdrive\rap\Models;

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
        return $this->hasMany("processdrive\\rap\Models\Permission", "module_id", "id");
    }
}
