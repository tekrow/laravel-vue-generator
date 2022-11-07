* With this package, just run `php artisan lvg:generate articles`
* Build your css and javascript (About **27 seconds**)
DONE! In about **2 and a half minutes**, you get a fully working module consisting of -:
- Model
- Admin Controller - Index, Create, Show, Edit, Store, Update, Delete
- API Controller - Index, Store, Show, Update, Delete
- An Authorization Policy - viewAny, view, create, update, delete, restore, forceDelete
- Generated Permissions for [spatie/laravel-permissions](https://spatie.be/docs/laravel-permission/v4/introduction) - articles, articles.index, articles.create, articles.show, articles.edit, articles.delete
- Frontend Menu entry
- Frontend Datatable with Actions thanks to Using Yajra Datatables and datatables.net
- Tailwindcss-powered CREATE and EDIT forms,
- Tailwindcss - powered SHOW view.
- web and API routes
- Validation and Authorization Request Classes

What more could you ask for? Cut a day's work down to less than 3 minutes.

## Dependencies
If you have followed the [Jetstream - Inertia - Vue.js Installation](https://jetstream.laravel.com/2.x/stacks/inertia.html) instructions, then the project will work with minimal configuration.
Other Important dependencies that you MUST configure include:
1. [Spatie Laravel Permissions](https://spatie.be/docs/laravel-permission/v4/introduction) - This is used to manage roles and permissions. Its migrations will be published during asset publishing, after which you can go ahead and configure the user trait.
2. [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) - Used to manage both API and stateful authentication. Since the whole app will be a Single Page Application, make sure you configure the middleware sanctum middleware in `app/Http/Kernel.php` as follows:
```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ...
],
```
## Before You Install:
- Ensure you have installed `laravel/jetstream` with `inertia`.

## Installation
1. You can install the package via composer:
```bash
composer require tekrow/laravel-vue-generator
```
> :warning: 1. Before proceeding, ensure you have installed `laravel/jetstream` with `inertia`.
> 
> :warning: 2. Step 1 will install spatie/laravel-permission. Ensure you have published migrations for this package to create roles and permissions tables before proceeding.

```shell
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```
> :bulb: NB: The `title` field will be automatically added to the `roles` and `permissions` tables when the first CRUD is generated.
:::

2. Install the necessary `npm` dev dependencies by running the following command:
If you are using npm:
```shell
npm install --include=dev --legacy-peer-deps @headlessui/vue @inertiajs/inertia @inertiajs/inertia-vue3 @vitejs/plugin-vue popper.js @babel/plugin-syntax-dynamic-import dayjs dotenv numeral postcss postcss-import pusher-js laravel-echo laravel-vite sass sass-loader vite vue@^3.1 vue3-vt-notifications vue-flatpickr-component  vue-numerals mitt vue-select@beta dynamic-import-polyfill
```
Or if you are using yarn:
```shell
yarn add -D @headlessui/vue @vitejs/plugin-vue @inertiajs/inertia @inertiajs/inertia-vue3 popper.js @babel/plugin-syntax-dynamic-import dayjs dotenv numeral postcss postcss-import pusher-js laravel-echo laravel-vite sass sass-loader vite vue@^3.1 vue3-vt-notifications vue-flatpickr-component  vue-numerals mitt vue-select@beta dynamic-import-polyfill
```
Feel free to configure the color palette to your own preference, but for uniformity be sure to include `primary`,`secondary`, `success` and `danger` variants since they are used in the lvg template.

3.  Publish the Package's assets, configs, templates, components and layouts.
   This is necessary for you to get the admin layout and all the vue components used in the generated code:

__Option 1__ (Suitable for fresh installations)
```shell
php artisan vendor:publish --force --provider="Tekrow\LaravelVueGenerator\LaravelVueGeneratorServiceProvider"
```

__Option 2__ (Useful if you are upgrading the package or already have local changes you don't want to override.)
NB: If you only want to update some published files, delete only the published files that you want to update, then run the appropriate command below:
```shell
php artisan vendor:publish --tag=lvg-blade-templates #Publishes resources/views/app.blade.php. If it already exists, use --force to replace it
php artisan vendor:publish --tag=lvg-config #Publishes the config file. If it exists use --force to replace it.
php artisan vendor:publish --tag=lvg-routes #Publishes routes/lvg.php to hold routes for generated modules.If you have already generated some routes, be sure to back them up as this file will be reset if you --force it.
php artisan vendor:publish --tag=lvg-views #publishes Vue Components, app.js, bootstrap.js and Layout files. Use --force to force replace
php artisan vendor:publish --tag=lvg-scripts #publishes main.ts and Layout files. Use --force to force replace
php artisan vendor:publish --tag=lvg-css #publishes app.css. Use --force to force replace
php artisan vendor:publish --tag=lvg-assets #publishes logos and other assets
php artisan vendor:publish --tag=lvg-compiler-configs #publishes postcss.config.js,vite.config.js, tsconfig.json and tailwind.config.js
php artisan vendor:publish --tag=lvg-seeders #Publish database Seeders
```
4. Add the `LvgMiddleware` to the `web` middleware group in `app/Http/Kernel.php`:
```php
protected $middlewareGroups = [
    'web' => [
        ...,
        \Tekrow\LaravelVueGenerator\Middleware\LvgMiddleware::class,
    ],
];
```
5. Allow First-Party access to the Sanctum API by adding the following to the `api` middleware group in `app/Http/Kernel.php`
```php
protected $middlewareGroups = [
    'api' => [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ...
    ],
];
```
6. Modify the .env to have the following keys:
```env
APP_BASE_DOMAIN=mydomain.test
# or https
APP_SCHEME=http
#optional mix_app_uri (The path under which the app will be served. It is recommended to run the app from the root of the domain.
MIX_APP_URI= 
#If MIX_APP_URI is empty.
APP_URL=${APP_SCHEME}://${APP_BASE_DOMAIN} 
#If MIX_APP_URI is not empty.
#APP_URL=${APP_SCHEME}://${APP_BASE_DOMAIN}/${MIX_APP_URI}

# Append the following key to your .env to allow 1st party consumption of your api:
#You can add other comma separated domains
SANCTUM_STATEFUL_DOMAINS="${APP_BASE_DOMAIN}"
```
7. create the storage:link (See laravel documentation) to allow access to the public disk assets (e.g logos) via web:
```shell
php artisan storage:link
```

8. Set the `scripts` in your `package.json` as follows:
```json
"scripts": {
        "dev": "vite",
        "build": "vite build",
        "serve": "vite preview"
    },
```
9. Enable Profile Photos by uncommenting the following line in `config/jetstream.php` under `'features'`:
```php
Features::profilePhotos(),
```
10. Run Migrations and Seeders
```shell
php artisan migrate
php artisan db:seed --class SeedAdminRoleAndUser
```
11. Now build the npm dependencies using `vitejs`:
```sh
yarn dev #Start the vitejs development server
yarn build #build assets for production

```

## Usage
### The initial seeded admin user and role
When you run `php artisan vendor:publish --tag=lvg-migrations`, a migration is published that creates an initial default user called `Administrator` and a role with the name `administrator` to enable you gain access to the system with admin privileges. The credentials for the user account are:
* Email: **admin@tekrow.com**
* Password: **password**

Use these creds after migration to login and explore all parts of the application

### Create the Permissions, Roles and Users Modules first, in that order:
Run the following commands to generate the User Access Control Module before proceeding to generate your admin:
```shell
php artisan lvg:generate:permission -f
php artisan lvg:generate:role -f
php artisan lvg:generate:user -f
```
You can now proceed to generate any other CRUD you want using the steps in the following section.
### General Steps to generate a CRUD:
1. Generate and write a migration for your table with `php artisan make:migration` command.
2. Run the migration to the database with `php artisan migrate` command
3. Generate the Whole Admin Scaffold for the module with `php artisan lvg:generate` command
4. Modify and customize the generated code to suit your specific requirements if necessary.
__NB: If the crud already exists, and you would like to generate, you can use the `-f` or `--force` option to force replacement of files.
### Example
Assuming you want to generate a `books` table:
```shell
php artisan make:migration create_books_table
```


* Open your migration and modify it as necessary, adding your fields. After that, run the migration.
```shell
php artisan migrate
```
* __The Fun Part:__ Scaffold a whole admin module for books with lvg using the following command:
```shell
php artisan lvg:generate books #Format: php artisan generate [table_name] [-f]
```
__NB:__ To get a full list of `lvg` commands called under the hood and the full description of the `lvg:generate` command, you can run the following: 
```shell
php artisan lvg --help
php artisan lvg:generate --help
```
The command above will generate a number of files and add routes to both your `api.php` and `web.php` route files. It will also append menu entries to the published `Menus.json` file.
The generated vue files are placed under the Pages/Books folder in the js folder.

* Finally, run `yarn dev or yarn build` to compile the assets. There you have your CRUD.
## Roles, permissions and Sidebar Menu:
* By Default, generation of a module generates the following permissions:
    - index
    - create
    - show
    - edit
    - delete
    
* The naming convention for permissions is ${module-name}.${perm} e.g payments.index, users.create etc.
* This package manages access control using policies. Each generated module generates a policy with the default laravel actions:
    - viewAny, view, store, update, delete, restore, forceDelete
  The permissions generated above are checked in these policies. If you need to modify any of the access permissions, policies is where to look.
      
* Special permissions MUST also be generated to control access to the sidebar menus. These permissions SHOULD NOT contain two parts separated with a dot, but only one part.
* Menus are configured in a json file published at `./resources/js/Layouts/Lvg/Menu.json`. 
    - For all menu items, the json key MUST match the permision that controls that menu. A permission without any verb is generated when generating each module for this very purpose. For example, generating a `payments` module will generate a `payments` permission.
      Then the menu for payments must have `payments` as the json key.
    - For parent menus and any other menus which may not match any module, you have to create a permission with the key name to control its access. For example, if you have a parent menu called `master-data` you have to generate a permission with the same name.

## Components Documentation
### Datatables
LVG is built on top of datatables.net and is fully server-side rendered using [Yajra Datatables](https://yajrabox.com/docs/laravel-datatables/master/introduction). Most of the logic resides inside `App\Repositories` and in the respective Repository file, there is a method called `dtColumns` which is used to fully control the columns shown in the Index page.

For example, in order to control the columns shown for the Users Datatable, the following is the `dtColumns` method under `App\Repositories\Users.php`:
```php
public static function dtColumns(): array
    {
        return [
            Column::make('id')->title('ID')->className('all text-right'),
            Column::make("name")->className('all'),
            Column::make("first_name")->className('none'),
            Column::make("last_name")->className('none'),
            Column::make("middle_name")->className('none'),
            Column::make("username")->className('min-desktop-lg'),
            Column::make("email")->className('min-desktop-lg'),
            Column::make("gender")->className('min-desktop-lg'),
            Column::make("dob")->className('none'),
            //Column::make("email_verified_at")->className('min-desktop-lg'),
            Column::make("activated")->className('min-desktop-lg'),
            Column::make("created_at")->className('min-tv'),
            Column::make("updated_at")->className('min-tv'),
            Column::make('actions')->className('min-desktop text-right')->orderable(false)->searchable(false),
        ];
    }
```
**NOTE: In order to omit the `email_verified_at` class from my Index columns all I had to do is comment it out (or better yet, just remove it from the list of columns!)**

The datatables are also responsive by default (Checkout https://datatables.net/extensions/responsive/ for more details). For this purpose, you can use one of the following lvg-provided responsive breakpoints to automatically collapse the column below a given screen size. For info on how to use the class logic, checkout the [Class Logic Documentation](https://datatables.net/extensions/responsive/classes). Most of the time I only use `min-`, e.g `min-desktop-l`
```ts
breakpoints: [
        { name: "tv", width: Infinity },
        { name: "desktop-l", width: 1536 },
        { name: "desktop", width: 1280 },
        { name: "tablet-l", width: 1024 },
        { name: "tablet-p", width: 768 },
        { name: "mobile-l", width: 480 },
        { name: "mobile-p", width: 320 },
    ],
}
```
Checkout the first snippet on how I have used the responsive classes!


### Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits
All credit goes to [Original Developers](https://github.com/savannabits)
I just needed to modify may be use vuetify and keep it updated as they have shifted to the development of [Acacia](https://github.com/savannabits/acacia)

## License

Do whatever you want no license required
