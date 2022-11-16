<?php

namespace Tekrow\Lvg\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Tekrow\Lvg\Commands\LvgInstall;
use Tekrow\Lvg\Commands\CommandMakeCommand;
use Tekrow\Lvg\Commands\ComponentClassMakeCommand;
use Tekrow\Lvg\Commands\ComponentViewMakeCommand;
use Tekrow\Lvg\Commands\ControllerMakeCommand;
use Tekrow\Lvg\Commands\DisableCommand;
use Tekrow\Lvg\Commands\DumpCommand;
use Tekrow\Lvg\Commands\EnableCommand;
use Tekrow\Lvg\Commands\EventMakeCommand;
use Tekrow\Lvg\Commands\FactoryMakeCommand;
use Tekrow\Lvg\Commands\InstallCommand;
use Tekrow\Lvg\Commands\JobMakeCommand;
use Tekrow\Lvg\Commands\LvgV6Migrator;
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

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Namespace of the console commands
     * @var string
     */
    protected $consoleNamespace = "Tekrow\\Lvg\\Commands";

    /**
     * The available commands
     * @var array
     */
    protected $commands = [
        LvgInstall::class,
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
        RepositoryMakeCommand::class,
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
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LvgV6Migrator::class,
        ComponentClassMakeCommand::class,
        ComponentViewMakeCommand::class,
    ];

    public function register(): void
    {
        $this->commands($this->resolveCommands());
    }

    private function resolveCommands(): array
    {
        $commands = [];

        foreach (config('modules.commands', $this->commands) as $command) {
            $commands[] = Str::contains($command, $this->consoleNamespace) ?
                $command :
                $this->consoleNamespace . "\\" . $command;
        }

        return $commands;
    }

    public function provides(): array
    {
        return $this->commands;
    }
}
