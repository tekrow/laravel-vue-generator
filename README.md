# lvg

Backend Modular Code and CRUD generator for Laravel 9.
The code is generated in the following stack:
* Laravel ^9
* Inertia.js
* Laravel Breeze & Sanctum
* Vue.js ^3
* Tailwindcss ^3
* PrimeVue ^3.11
## Before Installation
Before you begin installation, you have to prepare your laravel app by installing the following:
1. Install and Configure Laravel Sanctum [Follow these Steps](https://laravel.com/docs/9.x/sanctum#installation)
```bash

```
2. Install and configure Laravel Breeze as the authentication package [Follow these steps](https://laravel.com/docs/9.x/starter-kits#laravel-breeze-installation)
3. Install and configure `spatie/laravel-permission`. [Follow these Steps](https://spatie.be/docs/laravel-permission/v5/installation-laravel)
4. Install and configure `laravel/scout`. By default, lvg will try to configure the basic `database` driver for scout during installation. [Follow Scout Installation steps](https://laravel.com/docs/9.x/scout#installation)

Now you are ready to install Lvg!
lvg will be installed as a separate modular component, with its own frontend assets and even compilation process using vite.js, all separate from your main app, allowing you to even mix two frontend stacks together!

## Install

To install through Composer, by run the following command:

```bash
composer require Tekrow/lvg -W
```

By default, the Lvg's classes are not loaded automatically.
Before proceeding with installation, autoload the Lvg namespace and backend modules using `psr-4` by adding the following to your app's composer.json:

``` json
{
  "autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/",
        "Lvg\\": "lvg/"
    }
  }
}
```
**Tip: don't forget to run `composer dump-autoload` afterwards.**

The package will automatically register its service providers.
Then install the necessary files for code generation and backend by running:

```bash
php artisan lvg:install
```
**Tip: If you would like to force the replacement of existing Lvg files, add the --force option to the command above**
From here, you are ready to generate code and interact with your new backend.

Run the seeders for all modules. This is necessary in order to have the default Administrator role and user seeded. Without this step you won't be able to login immediately.
```bash
php artisan lvg:seed
```

To run compiler
```bash
cd lvg
npm run dev #to watch assets
```
To watch assets
```bash
npm run dev
```

To build the assets for production
```bash
npm run build
```
**Tip: The destination of the built assets is in public/vendor/lvg and the folder is cleared first with each build

Now you can login using these details

Username: `admin@tekrow.com`<br>
Password: `password`

During the installation step, the lvg config file is published to config/lvg.php. It has the following among other configs:

* lvg.route_prefix - allows you to define the uri under which the backend can be accessed. By default it is admin. You can change this by setting the env variable LVG_ROUTE_PREFIX
* lvg.sidebar.heading - Allows you to define the sidebar heading displayed above the backend's sidebar. You can change this by setting the env key LVG_SIDEBAR_HEADING
* lvg.dev_modules - It lists the modules that should not be available when the app is in production.

you can access it on domain/admin

### Module Structure
The modular structure of this package's generated code is heavily inspired by [nwidart/laravel-modules](https://nwidart.com/laravel-modules/v6/introduction). In fact, the generated modules are almost similar, with only slight differences in the folder structure.
Folder

**ModuleName/**

Parent folder for the module the module. Each CRUD generated will be created as a separate module.  
The module name takes the plural Pascal case form of the table name. E.g if the table name is `user_types` the module name hence the folder name will be `UserTypes`

**Config/**

Holds the module's configuration files

**Console/**

Holds the module's console commands

**Database/**

Holds the module's migrations, factories and seeders

**Http/**

Holds the module's controllers, middleware and requests.  
Validation and Authorization are done within Request classes. Currently the generated request classes include `IndexRequest`,`ViewRequest`,`StoreRequest`,`UpdateRequest`,`DestroyRequest` and `DtRequest` for the datatable.  
There are two generated controllers: the `web` controller and the `api` controller

**Js/**

Holds the module's javascript assets. These are mainly `Vue.js 3` components and pages.  
The backend uses `Inertia.js` to handle requests from Vue.js pages. If you need to customize your UI, this is mostly where you will dwell in after code generation.  
Most of the common layout and component files are located in the `Core` module inside the `Js` folder, which you will find aliased as `@/` to other components

**Models/**

Holds the models for the module. Only one main Model will be generated per module. You can add more models in the same module if you like.

**Policies/**

Holds the Authorization logic for the module. Only one main Authorization policy is generated. The policies have been configured to check the available permissions from `laravel-permission`.

**Providers/**

Holds the module's Main Service Provider and any other Service Providers for the module

**Repositories/**

Holds the Repositories for the module. Only one Repository is initially generated but you can create more. The `Repository` class holds all the logic for the CRUD. The work of controllers is merely to receive validated and authorized user input, pass the input to the Repository and return a response to the user after the action is completed.

**resources/**

This is used to load the module's blade views and other modular assets just in case you may want to extend the module. Currently it is not in use, but it was retained from `nwidart/laravel-module`'s design.

**Routes/**

This contains the module's routes. There are two separate route files: `api.php` and `web.php` You can read more in the Routing Section.

**tests/**

Holds the module's Unit and Feature tests. Currently, tests are not generated yet.

**composer.json**

This is the module's composer definition

**module.json**

This is the module's definition file.

**package.json**

The module's `package.json` just in case you want to extend the module with other dependencies. These are compiled by running the module's `webpack.mix`

**webpack.mix.js**

The module's `webpack.mix` file to be used for compiling the `assets` inside the `resources` folder. This is not used in the generated code, but it felt right to still maintain it from `nwidart/laravel-modules'` structure.

**package.json**

Inside `lvg/`, this is the main npm dependencies definition file. Most of these dependencies are the ones used in the `Core` module, hence shared with all the other modules.

**package-lock.json**

The lock file for the main `package.json` file

**tailwind.config.ts**

The main `tailwindcss` configuration file. If you would like to change your theme colors or any other tailwindcss settings, this is the place to do it.

**tsconfig.json**

All the `Vue` pages are written in `typescript`. This is the main `typescript config` file for development

**vite.config.ts**

The backend assets are compiled using `vite.js`. This is the main `vite config` file.

### Basic Usage
Lvg generates code based on an existing database. If the database does not exist yet, the first step is to write and run migrations. To better illustrate, we will be generating one of the CRUDs needed to build a vehicles web app. Let's create an vehicle_types table:

```bash
php artisan make:migration create_vehicle_types_table
```

Populate the migration with this content:
```php
    Schema::create('vehicle_types', function (Blueprint $table) {
        $table->increments('id');
        $table->string('slug')->unique();
        $table->string('name')->unique();
        $table->text('description')->nullable();
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
```
Run the migration
```bash
php artisan migrate
```

### Preparing Schematics
1. Generate a schematic for the module. The schematic defines the fields and relationships of the module. Later the generation command will use this information when generating the code. You can create the code from the interface, or simply run the following command:

```bash
php artisan lvg:blueprint vehicle_types
```

2. Now Generate the code
```bash
php artisan lvg:make vehicle_types
```
The command will generate the VehicleTypes module, whose files will be under the folder lvg/VehicleTypes/

**Tip:  If the module already exists and you would like to force its replacement, you can specify -F or --force to the lvg:make command.

If the vehicle_types Schematic did not exist, running lvg:make will generate it first before proceeding.

Now to compile and watch the assets

```bash
cd lvg
npm run dev
```
### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
