<?php

namespace IBroStudio\PolymorphicTeam;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use IBroStudio\PolymorphicTeam\Commands\PolymorphicTeamCommand;

class PolymorphicTeamServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('polymorphic-team')
            ->hasConfigFile(['polymorphic-team', 'teamwork'])
            ->hasMigration('polymorphic_team_tables_setup')
            ->hasCommand(PolymorphicTeamCommand::class)
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    //->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations();
                    //->askToStarRepoOnGitHub('your-vendor/your-repo-name');
            });
    }
}
