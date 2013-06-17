<?php

namespace Fathom\Builder;

class Builder
{
    private $className;

    private $namespace;

    private $definitions;

    private $fields;

    public function __construct(array $schema)
    {
        $this->guessClassName($schema['class']);
        $this->guessNamespace($schema['class']);
        $this->guessFields($schema['fields']);
    }

    public function guessClassName($class)
    {
        $expl = explode('\\', $class);
        $this->className = $expl[count($expl)-1];
    }

    public function guessNamespace($class)
    {
        $expl = explode('\\', $class);
        unset($expl[count($expl)-1]);

        $this->namespace = implode('\\', $expl);
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function guessFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }
}