<?php

$middleware = \Config::get('rap.rap_config.middlewares');

$prefix = 'processdrive/rap';
$namespace = 'processdrive\rap\app\Http\Controllers';

// make sure authenticated
Route::group(compact('middleware', 'prefix', 'namespace'), function () {

    // Role
    Route::get('roles/index', 'RoleController@index')->name('roles.index');
    Route::get('roles/create', 'RoleController@create')->name('roles.create');
    Route::post('roles/store', 'RoleController@store')->name('roles.store');
    Route::get('roles/destroy/{id}', 'RoleController@destroy')->name('roles.delete');
    Route::get('roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
    Route::post('roles/update/{id}', 'RoleController@update')->name('roles.update');
    Route::get('roles/search/{search?}', 'RoleController@index')->name('roles.search');

    // Permission
    Route::get('roles/assignPermission/{id}', 'RoleController@assignPermission')->name('roles.assignPermission');
    Route::post('assignRolesAndPermission/getActionForRAP', 'RoleController@getActionForRAP')->name('datatable.getActionForRAP');
    Route::post('roles/saveRAP', 'RoleController@saveRAP')->name('roles.saveRAP');

    // rapModules
    Route::get('rapModules/index', 'rapModulesController@index')->name('rapModules.index');
    Route::get('rapModules/createPermission/{id}', 'rapModulesController@createPermission')->name('rapModules.createPermission');
    Route::get('rapModules/render/actions/{id}', 'rapModulesController@renderAction')->name('rapModules.renderAction');
    Route::post('rapModules/save/actions', 'rapModulesController@saveAction')->name('rapModules.saveActions');
    Route::get('rapModules/edit/actions', 'rapModulesController@editAction')->name('rapModules.editActions');
    Route::get('rapModules/delete/actions', 'rapModulesController@deleteAction')->name('rapModules.deleteActions');
    Route::get('rapModules/search/{search?}', 'rapModulesController@index')->name('rapModules.search');

    // Action
    Route::get('rapAction/search/{module_id}/{search?}', 'rapModulesController@createPermission')->name('rapAction.search');
});