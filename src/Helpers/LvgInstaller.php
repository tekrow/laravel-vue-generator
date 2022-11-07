<?php

namespace Tekrow\LaravelVueGenerator\Helpers;

use Illuminate\Console\Command;
class LvgInstaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lvg:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is an automatic installer for the Laravel Vue Generator Package. It will install packages, publish all assets and schedule or run migrations for you.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Run yarn install,
        // Run vendor publish commands
        // Add the LvgMiddleware to the Kernel
        // Publish Sanctum config
        // Add sanctum API middleware
        // Publish permissions and Roles,
        // Run Role Generator
        // Run Permission generator
        // Run user generator.
        return 0;
    }
}
