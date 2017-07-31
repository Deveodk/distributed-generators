<?php

namespace DeveoDK\DistributedGenerators\Commands\Exceptions;

use DeveoDK\DistributedGenerators\Traits\BundleTrait;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class ExceptionMakeCommand extends GeneratorCommand
{
    use BundleTrait;

    /**
     * The signature and name of the command
     * @var string
     */
    protected $signature = 'make:bundle:exception {name} {--namespace=} {--basenamespace=} {--bundlename=}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a new application bundle exception';

    /**
     * The type of class being generated.
     * @var string
     */
    protected $type = 'Exception';

    /**
     * The namespace where it should be placed
     * @var string
     */
    protected $namespace;

    /**
     * The base namespace that the exception should extend
     * @var string
     */
    protected $baseNamespace;

    /**
     * The bundle name that the exception should replace
     * the error description with
     * @var string
     */
    protected $bundleName;

    /**
     * The directory it should be generated in
     * @var string
     */
    protected $directory = 'Exceptions';

    public function __construct(Filesystem $files)
    {
        $this->category = 'Exception';
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
        if ($this->option('basenamespace')) {
            $this->baseNamespace = $this->option('basenamespace');
        }
        if ($this->option('bundlename')) {
            $this->bundleName = $this->option('bundlename');
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
        return __DIR__ . '/../../stubs/exceptions/exception.stub';
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
        $stub = str_replace('DummyClass', $name, $stub);
        $stub = str_replace('DummyRootException', $this->baseNamespace, $stub);
        $stub = str_replace('DummyBundleName', $this->bundleName, $stub);
        $stub = str_replace('DummyNamespace',
            ucfirst($this->revertSlashToBackslash($this->namespace) . '\\' . $this->directory), $stub);
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
