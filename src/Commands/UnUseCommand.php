<?php

namespace Tekrow\Lvg\Commands;

use Illuminate\Console\Command;

class UnUseCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lvg:unuse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forget the used module with lvg:use';

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $this->laravel['modules']->forgetUsed();

        $this->info('Previous module used successfully forgotten.');

        return 0;
    }
}
