<?php

namespace IBroStudio\Polyteam;

use IBroStudio\Polyteam\Commands\PolyteamCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PolyteamServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('polymorphic-team')
            ->hasConfigFile(['polyteam', 'teamwork'])
            ->hasMigration('polyteam_tables_setup')
            ->hasCommand(PolyteamCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    //->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations();
                //->askToStarRepoOnGitHub('your-vendor/your-repo-name');
            });
    }
}
