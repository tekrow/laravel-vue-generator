<?php

use Tekrow\Lvg\Activators\FileActivator;
use Tekrow\Lvg\Commands\LvgV6Migrator;
use Tekrow\Lvg\Commands\CommandMakeCommand;
use Tekrow\Lvg\Commands\ControllerMakeCommand;
use Tekrow\Lvg\Commands\DisableCommand;
use Tekrow\Lvg\Commands\DumpCommand;
use Tekrow\Lvg\Commands\EnableCommand;
use Tekrow\Lvg\Commands\EventMakeCommand;
use Tekrow\Lvg\Commands\FactoryMakeCommand;
use Tekrow\Lvg\Commands\InstallCommand;
use Tekrow\Lvg\Commands\JobMakeCommand;
use Tekrow\Lvg\Commands\ListCommand;
use Tekrow\Lvg\Commands\ListenerMakeCommand;
use Tekrow\Lvg\Commands\MailMakeCommand;
use Tekrow\Lvg\Commands\MiddlewareMakeCommand;
use Tekrow\Lvg\Commands\MigrateCommand;
use Tekrow\Lvg\Commands\MigrateRefreshCommand;
use Tekrow\Lvg\Commands\MigrateResetCommand;
use Tekrow\Lvg\Commands\MigrateRollbackCommand;
use Tekrow\Lvg\Commands\MigrateStatusCommand;
use Tekrow\Lvg\Commands\MigrationMakeCommand;
use Tekrow\Lvg\Commands\ModelMakeCommand;
use Tekrow\Lvg\Commands\ModuleDeleteCommand;
use Tekrow\Lvg\Commands\ModuleMakeCommand;
use Tekrow\Lvg\Commands\NotificationMakeCommand;
use Tekrow\Lvg\Commands\PolicyMakeCommand;
use Tekrow\Lvg\Commands\ProviderMakeCommand;
use Tekrow\Lvg\Commands\PublishCommand;
use Tekrow\Lvg\Commands\PublishConfigurationCommand;
use Tekrow\Lvg\Commands\PublishMigrationCommand;
use Tekrow\Lvg\Commands\PublishTranslationCommand;
use Tekrow\Lvg\Commands\RepositoryMakeCommand;
use Tekrow\Lvg\Commands\RequestMakeCommand;
use Tekrow\Lvg\Commands\ResourceMakeCommand;
use Tekrow\Lvg\Commands\RouteProviderMakeCommand;
use Tekrow\Lvg\Commands\RuleMakeCommand;
use Tekrow\Lvg\Commands\SeedCommand;
use Tekrow\Lvg\Commands\SeedMakeCommand;
use Tekrow\Lvg\Commands\SetupCommand;
use Tekrow\Lvg\Commands\TestMakeCommand;
use Tekrow\Lvg\Commands\UnUseCommand;
use Tekrow\Lvg\Commands\UpdateCommand;
use Tekrow\Lvg\Commands\UseCommand;

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Lvg',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        'path' => base_path() . '/vendor/Tekrow/lvg-generator/src/Commands/stubs',
        'files' => [
            'routes/web' => 'Routes/web.php',
            'routes/api' => 'Routes/api.php',
            'views/index' => 'resources/views/index.blade.php',
            'views/master' => 'resources/views/layouts/master.blade.php',
            'scaffold/config' => 'Config/config.php',
            'composer' => 'composer.json',
            'assets/js/app' => 'resources/assets/js/app.js',
            'assets/sass/app' => 'resources/assets/sass/app.scss',
            'js/pages/index' => 'Js/Pages/Index.vue',
            'js/pages/create' => 'Js/Pages/Create.vue',
            'js/pages/edit' => 'Js/Pages/Edit.vue',
            'js/pages/show' => 'Js/Pages/Show.vue',
            'js/pages/partials/create-form' => 'Js/Pages/Partials/CreateForm.vue',
            'js/pages/partials/edit-form' => 'Js/Pages/Partials/EditForm.vue',
            'js/pages/partials/show-form' => 'Js/Pages/Partials/ShowForm.vue',
            'webpack' => 'webpack.mix.js',
            'package' => 'package.json',
        ],
        'replacements' => [
            'routes/web' => ['LOWER_NAME', 'STUDLY_SINGULAR_NAME'],
            'routes/api' => ['LOWER_NAME', 'STUDLY_SINGULAR_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'js/pages/index' => ['MODEL_NAME','LOWER_NAME','STUDLY_NAME','STUDLY_SINGULAR_NAME','JS_INDEX_COLUMNS','JS_INDEX_TITLE','JS_SINGULAR_TITLE','JS_INDEX_SEARCHABLE_COLS'],
            'js/pages/create' => ['MODEL_NAME','LOWER_NAME','STUDLY_NAME','STUDLY_SINGULAR_NAME','JS_CREATE_TITLE'],
            'js/pages/partials/create-form' => [
                'LOWER_NAME',
                'MODEL_NAME',
                'CREATE_COMPONENT_IMPORTS',
                'STUDLY_NAME',
                'STUDLY_SINGULAR_NAME',
                'CREATE_FORM_OBJECT',
                'CREATE_FORM_FIELDS'
            ],
            'js/pages/edit' => ['MODEL_NAME','LOWER_NAME','STUDLY_NAME','STUDLY_SINGULAR_NAME','JS_EDIT_TITLE'],
            'js/pages/show' => ['MODEL_NAME','LOWER_NAME','STUDLY_NAME','STUDLY_SINGULAR_NAME','JS_SHOW_TITLE'],
            'js/pages/partials/edit-form' => [
                'MODEL_NAME',
                'LOWER_NAME',
                'EDIT_COMPONENT_IMPORTS',
                'STUDLY_NAME',
                'STUDLY_SINGULAR_NAME',
                'EDIT_FORM_FIELDS'
            ],
            'js/pages/partials/show-form' => [
                'LOWER_NAME',
                'SHOW_COMPONENT_IMPORTS',
                'STUDLY_NAME',
                'STUDLY_SINGULAR_NAME',
                'SHOW_FORM_FIELDS'
            ],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('lvg'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('lvg-modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'lvg:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'config'    => ['path' => 'Config', 'generate' => true],
            'command'   => ['path' => 'Console', 'generate' => true],
            'migration' => ['path' => 'Database/Migrations', 'generate' => true],
            'seeder'    => ['path' => 'Database/Seeders', 'generate' => true],
            'factory'   => ['path' => 'Database/Factories', 'generate' => true],
            'model'     => ['path' => 'Models', 'generate' => true],
            'routes'    => ['path' => 'Routes', 'generate' => true],
            'controller'=> [ 'namespace' =>'Http\Controllers', 'path' => 'Http/Controllers', 'generate' => true],
            'api-controller' => ['namespace' =>'Http\Controllers\Api', 'path' => 'Http/Controllers/Api', 'generate' => true],
            'filter'    => ['path' => 'Http/Middleware', 'generate' => true],
            'request'   => ['namespace' =>'Http\Requests','path' => 'Http/Requests', 'generate' => true],
            'provider'  => ['path' => 'Providers', 'generate' => true],
            'assets'    => ['path' => 'resources/assets', 'generate' => true],
            'lang'      => ['path' => 'resources/lang', 'generate' => true],
            'views'     => ['path' => 'resources/views', 'generate' => true],
            'test'      => ['path' => 'tests/Unit', 'generate' => true],
            'test-feature'      => ['path' => 'tests/Feature', 'generate' => true],
            'repository'        => ['path' => 'Repositories', 'generate' => true],
            'event'             => ['path' => 'Events', 'generate' => false],
            'listener'          => ['path' => 'Listeners', 'generate' => false],
            'policies'          => ['path' => 'Policies', 'generate' => true],
            'rules'             => ['path' => 'Rules', 'generate' => false],
            'jobs'              => ['path' => 'Jobs', 'generate' => true],
            'emails'            => ['path' => 'Emails', 'generate' => false],
            'notifications'     => ['path' => 'Notifications', 'generate' => false],
            'resource'          => ['path' => 'Transformers', 'generate' => false],
            'component-view'    => ['path' => 'resources/views/components', 'generate' => false],
            'component-class'   => ['path' => 'View/Component', 'generate' => false],
            'vue-pages'         => ['path' => 'Js/Pages', 'generate' => true],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
    'commands' => [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        RepositoryMakeCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LvgV6Migrator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
    */

    'composer' => [
        'vendor' => 'Tekrow',
        'author' => [
            'name' => 'Waqas Ahmed',
            'email' => 't3krow@gmail.com',
        ],
    ],

    'composer-output' => false,

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'lvg',
        'lifetime' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Choose what lvg-generator will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => 'file',
];
