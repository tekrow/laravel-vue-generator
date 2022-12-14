<?php

namespace Lvg\Core\Providers;

use Lvg\Core\Console\Commands\AssignRoleCommand;
use Lvg\Core\Console\Commands\GPanelBlueprintCommand;
use App\Http\Kernel;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Lvg\Core\Console\Commands\LvgAssetsBuild;
use Lvg\Core\Console\Commands\LvgAssetsDev;
use Lvg\Core\Console\Commands\LvgAssetsInstall;
use Illuminate\Support\Str;

class LvgServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->commands([
            LvgAssetsInstall::class,
            LvgAssetsDev::class,
            LvgAssetsBuild::class,
            GPanelBlueprintCommand::class,
            AssignRoleCommand::class,
        ]);
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $kernel->appendMiddlewareToGroup("web",\Lvg\Core\Http\Middleware\HandleInertiaRequests::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        config(['database.connections.lvg' => array(
            'driver' => 'sqlite',
            'url' => '',
            'database' => module_path('Core','Database/lvg.sqlite'),
            'prefix' => '',
            'foreign_key_constraints' => true,
        )]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
        \Blade::anonymousComponentNamespace('components',$this->moduleNameLower);
        \Blade::componentNamespace('Lvg\\Core\\Components',$this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
