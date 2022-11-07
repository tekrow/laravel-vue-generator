<?php

namespace Tekrow\LaravelVueGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tekrow\LaravelVueGenerator\Skeleton\SkeletonClass
 */
class LaravelVueGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-vue-generator';
    }
}
