<?php

namespace Tekrow\Lvg\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Tekrow\Lvg\Helpers\Helpers;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class LvgInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lvg:install {--F|force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Lvg and prepare the app for code generation';

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
    public function handle(): int
    {
        $force = $this->option('force');
        $configOpts =  ['--tag' => 'lvg-config'];
        $moduleOpts =  ['--tag' => 'lvg-modules'];
        $permissions =  ['--provider' => 'Spatie\Permission\PermissionServiceProvider'];
        $scout =  ['--provider' => 'Laravel\Scout\ScoutServiceProvider'];
        $this->alert("Begin Installation");
        if ($force) {
            if (file_exists('./lvg/Core/Database/lvg.sqlite')){
                $this->info("Backing up the SQlite DB");
                Helpers::runShellCommand('cp ./lvg/Core/Database/lvg.sqlite ./lvg/lvg.sqlite.latest');
            }
            $this->info("Removing lvg/Core");
            Helpers::runShellCommand('rm -rf lvg/Core');
            $this->info("Removing lvg/package.json");
            Helpers::runShellCommand('rm -rf lvg/package.json');
            $this->info("Removing lvg/tsconfig.json");
            Helpers::runShellCommand('rm -rf lvg/tsconfig.json');
            $this->info("Removing lvg/tailwind.config..ts");
            Helpers::runShellCommand('rm -rf lvg/tailwind.config.ts');
            $this->info("Removing lvg/vite.config..ts");
            Helpers::runShellCommand('rm -rf lvg/vite.config.ts');
            if (file_exists(config_path('lvg.php'))) {
                Helpers::runShellCommand('rm -rf '.config_path('lvg.php'));
            }
        }
        $this->info("1. Publishing files");
        $this->info("   a. Publishing lvg configs");
        $this->call("vendor:publish",$configOpts);
        $this->info("   b. Publishing lvg core module");
        $this->call("vendor:publish",$moduleOpts);
        $this->info("   c. Publishing laravel permission config and migration");
        $this->call("vendor:publish",$permissions);
        $this->info("   d. Publishing laravel scout config");
        $this->call("vendor:publish",$scout);
        $this->info("Dump autoload");
        $newDb = false;
        Helpers::runShellCommand('composer dump-autoload');
        if (!file_exists('./lvg/Core/Database/lvg.sqlite')){
            $newDb = true;
            $this->info("Creating initial sqlite db");
            Helpers::runShellCommand('cp ./lvg/lvg.sqlite.latest ./lvg/Core/Database/lvg.sqlite');
        }
        $this->info("3. Enable initial modules");
        $this->call("lvg:enable");
        $this->info("Configure lvg db config temporarily");
        Helpers::configureLvgDb();
        Helpers::runShellCommand('composer dump-autoload', $this);
        if ($newDb) {
            $this->info("2. Running GPanel Migrations");
            $this->call('migrate:fresh',['--path' => 'lvg/Core/Database/SqliteMigrations', '--database' =>'lvg']);
        }
        $this->info("2. Running Initial Modules Seeders");
        $this->call('lvg:seed');
        if (!Route::has('login')) {
            $this->info("We couldn't find the login route. Ensuring breeze is installed");
            $this->call('breeze:install');
        }
        $this->info("Attempt to install the app's npm dependencies");
        Helpers::runShellCommand("npm install && npm run build", $this);
        $this->info("Attempt to install lvg's npm dependencies");
        Helpers::runShellCommand("cd lvg && npm install && npm run build", $this);
        $this->alert('Installation Complete');
        $this->warn("NB: To install npm dependencies: `cd lvg/ && npm install` or simply run `php artisan lvg:assets-install`");
        $this->warn("NB: to compile npm assets: `cd lvg/ && npm run dev` or `cd lvg/ && npm run build`, or run the command `php artisan lvg:assets-build`");
        return 0;

        /**
        $this->call('lvg:blueprint',['table' => 'Permissions']);
        $this->call('lvg:blueprint',['table' => 'Roles']);
        $this->call('lvg:blueprint',['table' => 'Users']);
         */

    }
}
