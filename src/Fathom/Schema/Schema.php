<?php

namespace Fathom\Schema;

class Schema
{
    protected $filepath;

    protected $filename;

    protected $extension;

    protected $yamlSchema;

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    public function getFilepath()
    {
        return $this->filepath;
    }

    public function setYamlSchema($yamlSchema)
    {
        $this->yamlSchema = $yamlSchema;
    }

    public function getYamlSchema()
    {
        return $this->yamlSchema;
    }


}