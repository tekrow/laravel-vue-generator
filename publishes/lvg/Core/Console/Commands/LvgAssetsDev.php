<?php

namespace Lvg\Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class LvgAssetsDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lvg:assets-dev {--U|using=npm : Which package manager do you want to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install assets in the lvg Module';

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
        $command = \Str::lower($this->option('using')) ==='npm' ? 'npm run dev' : 'yarn dev';
        $path = "lvg/";
        $this->alert("Running $command in $path");
        run_shell_command("cd $path && $command", $this);
        $this->alert("DONE.");
        return 0;
    }
}
