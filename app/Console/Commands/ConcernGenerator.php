<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ConcernGenerator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:concern {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new concern';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Concern';

    /**
     * Get the stub file for generator
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/trait.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Concerns';
    }
}
