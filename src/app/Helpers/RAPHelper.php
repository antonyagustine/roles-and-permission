<?php

namespace processdrive\rap\app\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use flash;

class RAPHelper {

	public static $omit_action;
    public static $static_actions;
    public $action_array = [];

    /**
     * [actionArrays]
     * @return [void]
     */
    public static function actionArrays() {
    	$action_array['omit_action'] =  Config::get('rap.rap_config.omit_action');
        $action_array['static_actions'] = Config::get('rap.rap_config.static_action');

        return $action_array;
    }

	/**
	 * [routes]
	 * @return [void]
	 */
	public static function routes()	{
		Route::any('/{route}', function ($route) {
			return redirect('processdrive/rap/'.str_replace('.', '/', $route));
	    })->name('rap');
	}

	/**
	 * [getFlash]
	 * @return [str]
	 */
	public static function getFlash() {
		$msg = [];
		
		if (@$_SESSION['key']) {
			$msg['msg'] = trans('roles.'.$_SESSION['key'].'_msg');

			if (@$_SESSION['key'] === 'store' || 'destroy' || 'update' || 'roles')
			$msg['type'] = 'alert-success';
			else
			$msg['type'] = 'alert-danger';

			session_unset();

			return $msg;
		}
	}
}