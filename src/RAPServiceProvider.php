<?php

namespace processdrive\rap;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class RAPServiceProvider extends ServiceProvider
{

    protected $commands = [
        'processdrive\rap\app\Commands\GenerateTranslation',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive("hasPermission", function ($expression) {
            return "<?php if(\Auth::User()->hasPermission($expression)) { ?>";
        });
        
        \Blade::directive("endHasPermission", function () {
            return "<?php } ?>";
        });

        if (Config::get('rap.rap_config.use_package_routes')) {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        }

        $this->loadViewsFrom(__DIR__.'/views', 'rap');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/rap/public'),
        ], 'rap');

        $this->publishes([
            __DIR__.'/views' => public_path('vendor/rap/views'),
        ], 'rap');

        $this->publishes([
            __DIR__ . '/config/rap_config.php' => base_path('config/rap/rap_config.php'),
        ], 'rap');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'rap');

        $this->publishes([
            __DIR__ . '/lang' => base_path('resources/lang/en'),
        ], 'rap');

    }

    /**
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        
        $this->app->singleton('rap', function () {
           return true;
        });
    }
}
