<?php

namespace Fathom\Schema;

use Symfony\Component\Finder\Finder;

/**
 * Class SchemaLoader
 * @package Fathom
 */
class SchemaLoader {

    private $extension;

    private $schemaDirectory;

    private $resources;

    private $multiple;

    /**
     * Constructor method
     *
     * @param string $extension The default schema extension - default to 'yml'
     * @param string $schemaDirectory The default schema directory
     */
    public function __construct($extension = 'yml', $schemaDirectory = 'Schema')
    {
        if(null !== $extension){
            $this->setExtension = $extension;
            $this->setSchemaDirectory = $schemaDirectory;
        }
    }

    /**
     * Sets the default schema extension
     * Default is 'yml'
     *
     * @param $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Sets the default schemas directory
     *
     * @param $directory
     */
    public function setSchemaDirectory($directory)
    {
        $this->schemaDirectory = $directory;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param $resource
     */
    public function load($resource)
    {
        $res = $this->formatResourceName($resource);

        if(is_dir($res)){
            $finder = new Finder();
            $finder->files()->name('*.'.$this->getExtension())->in($res);
            return $finder;
        } elseif(is_file($resource)){
            $expl = explode(DIRECTORY_SEPARATOR, $resource);
            $res = array_pop($expl);
            $dir = implode(DIRECTORY_SEPARATOR, $expl);
            $finder = new Finder();
            $finder->files()->name($res)->in($dir);
            return $finder;
        }

    }

}