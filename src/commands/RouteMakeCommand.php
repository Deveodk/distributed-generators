<?php

namespace DeveoDK\DistributedGenerators\Commands;

use DeveoDK\DistributedGenerators\Traits\BundleTrait;
use Illuminate\Console\GeneratorCommand;

class RouteMakeCommand extends GeneratorCommand
{
    use BundleTrait;

    /**
     * The signature and name of the command
     * @var string
     */
    protected $signature = 'make:bundle:route {name} {--namespace=}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new application bundle route';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Route';

    /**
     * The namespace where it should be placed
     * @var string
     */
    protected $namespace;

    /**
     * Execute the command.
     */
    public function fire()
    {
        if ($this->option('namespace')) {
            $this->namespace = $this->option('namespace');
        }
        if (parent::fire() === false) {
            return;
        }
    }

    /**
     * Get the stub file for the generator.
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/Route.stub';
    }

    /**
     * Build the class with the given name.
     * @param  string $name
     * @return string
     */
    protected function buildClass($name = null)
    {
        $stub = $this->files->get($this->getStub());
        return $this->replaceClass($stub, $name);
    }

    /**
     * Replace the class name for the given stub.
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $routeName = strtolower(str_plural($this->isVersionRoute(strtolower(str_plural($name)))));
        $name = $this->getFileName($name);
        $stub = str_replace('DummyRoute', $routeName, $stub);
        $stub = str_replace('DummyController', $name.'Controller', $stub);
        return $stub;
    }

    /**
     * Returns correctly formatted route name
     * Only formats if version route
     * @param $namespace
     * @return string
     */
    protected function isVersionRoute($namespace)
    {
        $containsNumber = preg_replace("/[^0-9]/", "", $this->getNamespace($namespace));
        $name = $this->getFileName($namespace);
        if ($containsNumber !== "") {
            return '/v' . $containsNumber . '/' . $name;
        }
        return '/' . $name;
    }

    /**
     * Get the destination class path.
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = $this->getFileName($name);
        $namespace = $this->revertBackslashToSlash($this->namespace);
        return base_path() . '/' . $namespace .'/routes' .  '.php';
    }
}
