<?php

namespace Tekrow\Lvg\Providers;

use Illuminate\Support\ServiceProvider;
use Tekrow\Lvg\Contracts\RepositoryInterface;
use Tekrow\Lvg\Laravel\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}
