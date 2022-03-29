<p align="center">
  <!-- <img src="https://raw.githubusercontent.com/antony382/roles-and-permission/master/public/images/logo.png" style="width: 15% !important;max-width: 20% !important;">-->
</p>

![Latest Stable Version](https://poser.pugx.org/laravel/laravel/v/stable) [![Latest Unstable Version](https://poser.pugx.org/laravel/laravel/v/unstable)](https://packagist.org/packages/laravel/laravel) [![License](https://poser.pugx.org/laravel/laravel/license)](https://packagist.org/packages/laravel/laravel)


# Roles And Permission (RAP)

A simple package to assign RAP(Roles And Permission) for an application.

## Installation

Via composer
```
composer require "processdrive/rap":"dev-master"
```
Or set in composer.json
```
"require": {
    "processdrive/rap":"dev-master"
}
```

## Register Dependencies

Set configuration in `config/app.php`

```    
// Set providers.
'providers' => [
    Collective\Html\HtmlServiceProvider::class,
    processdrive\rap\RAPServiceProvider::class,
]

// Set aliases
'aliases' => [
    'Form' => 'Collective\Html\FormFacade',
    'Html' => 'Collective\Html\HtmlFacade',
    'RAPHelper' => processdrive\rap\app\Helpers\RAPHelper::class,
],
```

Set relationship in `app/User.php`

```
/**
 * @return @return \Illuminate\Database\Eloquent\Relations\belongsToMany
 */
public function roles() {
    return $this->belongsToMany("App\Models\Role","user_role", "user_id", "role_id");
}

/**
 * [hasPermission]
 * @param  [str]  $permission
 * @return boolean
 */
public function hasPermission($permission) {
    return $this->roles()->get()[0]->hasPermission($permission);
}
```

## Publish the package

```
php artisan vendor:publish --all
```

## Configuration

Set configuration in `config/rap/rap_config.php`

```
return [
    
    // Set Route access enable or disable
    'use_package_routes' => true,

    // Set middlewares
    'middlewares' => ['auth', 'CheckRole'],

    // Set Static Action
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

    //Set Omit Action it will be womited from permission module.
    'omit_action' => []
];
```



## Run command

``` 
composer dump-autoload
```

## Run migration

```
php artisan migrate
```

## Generate translation and DB seed

```
php artisan rap_generate:translation
```

## Edit translation files
```
resources/lang/en/rap_actions.php
resources/lang/en/rap_modules.php
```

## Add Route

Add Route in `routes/web.php`
    
```
Route::group(['middleware' => 'CheckRole'], function () {
    //add routes which are going to validate by RAP.
});

RAPHelper::routes();
```

## Add ifream in your application

Add ifream in your application

```
<iframe src="{{ route('rap', 'roles.index') }}" width="100%" height="100%" style=" border: 0;"></iframe>
```

## Register Middelware

register in your `app/Http/kernel.php`

```
protected $routeMiddleware = [
    'CheckRole' => processdrive\rap\app\Http\Middleware\CheckRole::class,
];     
```
## Usage

```
@hasPermission("viewSettings")
    // your code
@endHasPermission
```
