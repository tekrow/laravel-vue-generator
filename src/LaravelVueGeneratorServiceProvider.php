<?php

namespace Tekrow\LaravelVueGenerator;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Tekrow\LaravelVueGenerator\Helpers\LvgInstaller;
use Tekrow\LaravelVueGenerator\Middleware\LvgMiddleware;

class LaravelVueGeneratorServiceProvider extends RouteServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        parent::boot();
        \DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $this->commands([
            LaravelVueGenerator::class,
            RoleGenerator::class,
            PermissionsGenerator::class,
            UsersGenerator::class,
            Generators\Model::class,
            Generators\Policy::class,
            Generators\Repository::class,
            Generators\ApiController::class,
            Generators\Controller::class,
            Generators\ViewIndex::class,
            Generators\ViewForm::class,
            Generators\ViewFullForm::class,
            Generators\ModelFactory::class,
            Generators\Routes::class,
            Generators\ApiRoutes::class,
            Generators\IndexRequest::class,
            Generators\StoreRequest::class,
            Generators\UpdateRequest::class,
            Generators\DestroyRequest::class,
//            Generators\ImpersonalLoginRequest::class,
//            Generators\BulkDestroyRequest::class,
//            Generators\Lang::class,
            Generators\Permissions::class,
            Generators\Export::class,
        ]);
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-vue-generator');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'lvg');
//         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        /**
         * @var Router $router
         */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('lvg',LvgMiddleware::class);
         if (file_exists(base_path('routes/lvg.php'))) {

             $this->routes(function() {
                 Route::middleware(['web','lvg'])
                     ->namespace($this->namespace)
                     ->group(base_path('routes/lvg.php'));
             });
         } else {
             $this->loadRoutesFrom(__DIR__.'/routes.php');
         }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('lvg.php'),
                __DIR__.'/../config/vite.php' => config_path('vite.php'),
            ], 'lvg-config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/published-views' => resource_path('views'),
            ], 'lvg-blade-templates');

            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js'),
            ], 'lvg-views');

            $this->publishes([
                __DIR__.'/../resources/scripts' => resource_path('scripts'),
            ], 'lvg-scripts');

            $this->publishes([
                __DIR__.'/../resources/css' => resource_path('css'),
            ], 'lvg-css');

            $this->publishes([
                /* __DIR__.'/../database/migrations/seed_admin_role_and_user.php' => database_path("migrations/".now()->format("Y_m_d_H_i_s"). "_seed_admin_role_and_user.php"), */
            ], 'lvg-migrations');

            $this->publishes([
                __DIR__.'/../database/Seeders' => database_path("seeders"),
            ], 'lvg-seeders');

            $this->publishes([
                __DIR__.'/../resources/compiler-configs' => base_path(''),
            ], 'lvg-compiler-configs');

            $this->publishes([
                __DIR__.'/routes.php' => base_path('routes/lvg.php'),
            ], 'lvg-routes');


            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/lvg'),
            ], 'lvg-assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-vue-generator'),
            ], 'lang');*/

            // Registering package commands.
             $this->commands([LvgInstaller::class]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        parent::register();
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'lvg');
        // Register the main class to use with the facade
        $this->app->singleton('laravel-vue-generator', function () {
            return new LaravelVueGenerator;
        });
    }
}
