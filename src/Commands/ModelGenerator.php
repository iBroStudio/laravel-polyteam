<?php

namespace IBroStudio\Polyteam\Commands;

use Illuminate\Console\GeneratorCommand;

class ModelGenerator extends GeneratorCommand
{
    public $signature = 'polyteam:model {name}';

    public $description = 'Generate a polyteam model';

    protected $type = 'Model';

    protected function getStub()
    {
        return __DIR__ . '/stubs/polyteamModel.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models\Teams';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace('{{model}}', $class, $stub);
    }
}
