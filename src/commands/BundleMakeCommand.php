<?php

namespace DeveoDK\DistributedGenerators\Commands;

use DeveoDK\DistributedGenerators\Traits\BundleTrait;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class BundleMakeCommand extends GeneratorCommand
{
    use BundleTrait;

    /**
     * The signature and name of the command
     * @var string
     */
    protected $signature = 'make:bundle {name} {--all}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new application bundle';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Bundle';

    /**
     * The namespace where it should be placed
     * @var string
     */
    protected $namespace;

    /**
     * The relative namespace where it should be placed
     * @var string
     */
    protected $relativeNamespace;

    /**
     * BundleMakeCommand constructor.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->category = 'ServiceProvider';
        parent::__construct($files);
    }

    /**
     * Execute console command
     */
    public function fire()
    {
        $this->askForNamespace();

        if (parent::fire() === false) {
            return;
        }

        if ($this->option('all')) {
            $this->createModel();
            $this->createController();
            $this->createEvents();
            $this->createException();
            $this->createRoute();
            $this->createTransformer();
        }
    }

    /**
     * Generate a new model in the bundle
     */
    protected function createModel()
    {
        $name = $this->argument('name');
        $this->callSilent('make:bundle:model', [
            'name' => $this->getBundleName($name),
            '--namespace' => $this->relativeNamespace,
        ]);
    }

    /**
     * Generate a new controller in the bundle
     */
    protected function createController()
    {
        $name = $this->argument('name');
        $this->callSilent('make:bundle:controller', [
            'name' => $this->getBundleName($name),
            '--namespace' => $this->relativeNamespace,
        ]);
    }

    /**
     * Generate new events in the bundle
     */
    protected function createEvents()
    {
        $events = config('distributed.generators.eventTypes');
        $name = $this->argument('name');
        foreach ($events as $event) {
            $this->callSilent('make:bundle:event', [
                'name' => $this->getBundleName($name).$event,
                '--namespace' => $this->relativeNamespace,
            ]);
            $this->createListener($event);
        }
    }

    /**
     * Generate new listeners in the bundle
     * @param $eventName
     */
    protected function createListener($eventName)
    {
        $name = $this->argument('name');
            $this->callSilent('make:bundle:listener', [
                'name' => $this->getBundleName($name).$eventName,
                '--namespace' => $this->relativeNamespace,
            ]);
    }

    /**
     * Generate new route in the bundle
     */
    protected function createRoute()
    {
        $name = $this->argument('name');
        $this->callSilent('make:bundle:route', [
            'name' => $this->getBundleName($name),
            '--namespace' => $this->relativeNamespace,
        ]);
    }

    /**
     * Generate new transformer in the bundle
     */
    protected function createTransformer()
    {
        $name = $this->argument('name');
        $this->callSilent('make:bundle:transformer', [
            'name' => $this->getBundleName($name),
            '--namespace' => $this->relativeNamespace,
        ]);
    }

    /**
     * Generate new exception in the bundle
     */
    protected function createException()
    {
        $exceptions = config('distributed.generators.exceptionTypes');
        $name = $this->argument('name');
        foreach ($exceptions as $key => $exception) {
            $this->callSilent('make:bundle:exception', [
                'name' => $this->getBundleName($name).$key,
                '--bundlename' => $this->getBundleName($name),
                '--namespace' => $this->relativeNamespace,
                '--basenamespace' => $this->revertSlashToBackslash($exception),
            ]);
        }
    }

    /**
     * Ask the user for a directory to put the bundle.
     */
    protected function askForNamespace()
    {
        $namespaceArray = array_keys(config('optimus.components.namespaces'));
        $namespace = $this->choice('What folder would you like to use?', $namespaceArray);
        $this->namespace = str_replace('\\', '/', lcfirst($namespace));
    }

    /**
     * Get the stub file for the generator.
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/ServiceProvider.stub';
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
        $bundleName = $this->getBundleName($name);
        $namespace = $this->getNamespace($name) . '/'. $bundleName;
        $namespace = $this->revertSlashToBackslash($namespace);
        $this->relativeNamespace = $namespace;
        $name = $this->getFileName($name);
        $stub = str_replace('DummyClass', $name, $stub);
        $stub = str_replace('DummyNamespace', $namespace, $stub);
        return $stub;
    }

    /**
     * Get the destination class path.
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $relativeNamespace = $this->getRelativeNamespace($name);
        $name = $this->getFileName($name);
        return base_path() . '/' . $relativeNamespace . '/' . $name .  '.php';
    }
}
