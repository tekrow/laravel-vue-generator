<?php

namespace Tekrow\Lvg\Commands;

use Lvg\Core\Models\LvgMenu;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ModuleDeleteCommand extends Command
{
    protected $name = 'lvg:delete';
    protected $description = 'Delete a module from the application';

    public function handle() : int
    {
        $name = $this->argument('module');
        $lowerName = \Str::slug(\Str::pluralStudly($name));
        $route = "lvg.backend.$lowerName.index";
        LvgMenu::query()->where("route","=", $route)->forceDelete();
        $this->laravel['modules']->delete($this->argument('module'));
        $this->info("Module {$this->argument('module')} has been deleted.");

        return 0;
    }

    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The name of module to delete.'],
        ];
    }
}
