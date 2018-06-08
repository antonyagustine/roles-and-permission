<?php

namespace processdrive\rap\app\Models;

use Eloquent as Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use processdrive\rap\Updater;

class Model extends Models {
	
	use SoftDeletes, Updater;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];
}