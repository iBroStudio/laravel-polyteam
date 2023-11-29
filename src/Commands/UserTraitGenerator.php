<?php

namespace IBroStudio\Polyteam\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class UserTraitGenerator extends GeneratorCommand
{
    public $signature = 'polyteam:user {name} {model}';

    public $description = 'Generate user trait for a polyteam model';

    protected $type = 'Trait';

    protected function getStub()
    {
        return __DIR__.'/stubs/userTrait.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Models\Teams\Traits';
    }

    protected function replaceClass($stub, $name)
    {
        $class = $this->argument('model');

        return str_replace(
            ['{{model}}', '{{lower_model}}', '{{plural_model}}', '{{plural_lower_model}}'],
            [$class, Str::lower($class), Str::plural($class), Str::lower(Str::plural($class))],
            $stub
        );
    }
}
