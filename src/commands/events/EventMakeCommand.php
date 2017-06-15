<?php

namespace DeveoDK\DistributedGenerators\Commands\Events;

use DeveoDK\DistributedGenerators\Traits\BundleTrait;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class EventMakeCommand extends GeneratorCommand
{
    use BundleTrait;

    /**
     * The signature and name of the command
     * @var string
     */
    protected $signature = 'make:bundle:event {name} {--namespace=}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new application bundle events';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Event';

    /**
     * The namespace where it should be placed
     * @var string
     */
    protected $namespace;

    /**
     * The directory it should be generated in
     * @var string
     */
    protected $directory = 'Event';

    public function __construct(Filesystem $files)
    {
        $this->category = 'Event';
        parent::__construct($files);
    }

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
        return __DIR__ . '/../../stubs/events/event.stub';
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
        $name = $this->getFileName($name);
        $baseControllerNamespace = $this->revertSlashToBackslash(
            config('distributed.generators.rootNamespace.baseEvent')
        );
        $stub = str_replace('DummyClass', $name, $stub);
        $stub = str_replace('DummyRootNamespace', $baseControllerNamespace, $stub);
        $stub = str_replace('DummyNamespace',
            $this->revertSlashToBackslash($this->namespace) . '\\' . $this->directory, $stub);
        return $stub;
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
        return base_path() . '/' . $namespace . '/'. $this->directory .'/' . $name .  '.php';
    }
}
