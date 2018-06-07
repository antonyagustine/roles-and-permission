<?php

return [
    
    // Include to pre-defined routes from package or not. Middlewares
    'use_package_routes' => true,

    //auth middleware
    'middlewares' => ['auth', 'CheckRole'],

    // key => list/Trans value
    'static_action' => [
		'index' => 'List', 
		'create' => 'Create', 
		'show' => 'Show', 
		'edit' => 'Edit', 
		'destroy' => 'Destroy', 
		'store' => 'Store', 
		'update' => 'Update', 
		'delete' => 'Delete'
	],

	// key => list/Trans value
    'omit_action' => []

];
