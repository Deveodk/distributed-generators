<?php

namespace DeveoDK\DistributedGenerators\Traits;

trait BundleTrait
{

    /**
     * The category of the file generated
     * Used for appending to filename.
     * @var string
     */
    protected $category;

    /**
     * return the namespace
     * @return $namespace
     */
    protected function rootNamespace()
    {
        return $this->namespace;
    }

    /**
     * Remove the namespace from the name
     * @param $name
     * @return string
     */
    protected function removeNamespace($name)
    {
        return str_replace($this->getNamespace($name) . "\\", '', $name);
    }

    /**
     * Get the name of the bundle
     * @param $name
     * @return string
     */
    protected function getBundleName($name)
    {
        return $this->parseName($this->removeNamespace($name));
    }

    /**
     * Get the file name used with category
     * @param $name
     * @return string
     */
    protected function getFileName($name)
    {
        return $this->getBundleName($name) . $this->category;
    }

    /**
     * Get the relative namespace
     * @param $name
     * @return string
     */
    protected function getRelativeNamespace($name)
    {
        $namespace = $this->getNamespace($name);
        $bundleName = $this->getBundleName($name);
        return $namespace . '/' . $bundleName;
    }

    /**
     * Revert backslash to slash
     * @param $string
     * @return string
     */
    protected function revertBackslashToSlash($string)
    {
        return str_replace('\\', '/', $string);
    }

    /**
     * Revert slash to backslash
     * @param $string
     * @return string
     */
    protected function revertSlashToBackslash($string)
    {
        return str_replace('/', '\\', $string);
    }

    /**
     * Parse the name and format according to the root namespace.
     * @param  string $name
     * @return string
     */
    protected function parseName($name)
    {
        return ucwords(camel_case($name));
    }
}
