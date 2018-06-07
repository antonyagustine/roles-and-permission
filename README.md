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
        'middlewares' => ['auth'],

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

## Register Dependencies

Set configuration in `config/app.php`

```    
    // Set providers.
    'providers' => [
        processdrive\rap\RAPServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,
    ]

    // Set aliases
    'aliases' => [
        'Form' => 'Collective\Html\FormFacade',
        'Html' => 'Collective\Html\HtmlFacade',
        'RAPHelper' => \processdrive\rap\Helpers\RAPHelper::class,
    ],
```

## Run command

``` 
    composer dump-autoload
```

## Run migration

```
    php artisan migrate
```

## Generate translation and db seed

```
    php artisan rap_generate:translation
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

register in your app/Http/kernal.php

```
    protected $routeMiddleware = [
        'CheckRole' => processdrive\rap\Middleware\CheckRole::class,
    ];     
```
## Usage

```
    Create Role using left menue role option
```

    