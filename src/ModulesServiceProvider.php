<?php

namespace Tekrow\Lvg;

use Illuminate\Support\ServiceProvider;
use Tekrow\Lvg\Providers\BootstrapServiceProvider;
use Tekrow\Lvg\Providers\ConsoleServiceProvider;
use Tekrow\Lvg\Providers\ContractsServiceProvider;

abstract class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
    }

    /**
     * Register all modules.
     */
    public function register()
    {
    }

    /**
     * Register all modules.
     */
    protected function registerModules()
    {
        $this->app->register(BootstrapServiceProvider::class);
    }

    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($configPath, 'modules');
        $this->mergeConfigFrom(__DIR__.'/../publishes/config/config.php', 'lvg');
        $this->publishes([
            __DIR__.'/../publishes/config/config.php' => config_path('lvg.php'),
//            $configPath => config_path('modules.php'),
        ], 'lvg-config');
        $this->publishes([
            __DIR__.'/../publishes/config/scout.php' => config_path('scout.php'),
        ], 'lvg-scout');
        $this->publishes([
            __DIR__.'/../publishes/lvg' => base_path('lvg'),
        ], 'lvg-modules');
    }

    /**
     * Register the service provider.
     */
    abstract protected function registerServices();

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [Contracts\RepositoryInterface::class, 'modules'];
    }

    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(ContractsServiceProvider::class);
    }
}
