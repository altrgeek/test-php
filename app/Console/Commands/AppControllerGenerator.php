<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class AppControllerGenerator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:app {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new app controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'App controller';

    /**
     * Get the stub file for generator
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/app_controller.stub';
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
        return $rootNamespace . '\\Http\\Controllers\\App';
    }
}
