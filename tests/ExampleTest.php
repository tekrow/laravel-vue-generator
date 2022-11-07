<?php

namespace Tekrow\LaravelVueGenerator\Tests;

use Orchestra\Testbench\TestCase;
use Tekrow\LaravelVueGenerator\LaravelVueGeneratorServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelVueGeneratorServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
