<?php

namespace Fathom\Builder\Generator;

use TwigGenerator\Builder\Generator;
use Fathom\Builder\TwigBuilder;
use Fathom\Builder\Generator\MapperBuilder;

class NodeGenerator
{

    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    public function generateNode($map)
    {
        $builder = new TwigBuilder();
        $filename = $map->getClassName().'.php';
        $builder->setOutputName($filename);
        //$builder->setVariable('className', 'MyBuilder');

        $generator = new Generator();
        $generator->setTemplateDirs(array(__DIR__.'/Templates'));
        $generator->setMustOverwriteIfExists(true);
        $propertiesNames = array();
        foreach($map->getFields() as $k=>$v){
            $propertiesNames[] = array('lowercased'=>$k, 'camelcased'=>ucfirst($k));
        }
        $generator->setVariables(array(
            'className' => $map->getClassName(),
            'namespace' => $map->getNamespace(),
            'fields'    => $propertiesNames,
            'imports'   =>  array(),
            ));
        $generator->addBuilder($builder);
        $generator->writeOnDisk($this->directory);

        $mapperBuilder = new MapperBuilder();
        $fname = $map->getClassName().'Mapper.php';
        $mapperBuilder->setOutputName($fname);

        $generator = new Generator();
        $generator->setTemplateDirs(array(__DIR__.'/Templates'));
        $generator->setMustOverwriteIfExists(true);
        $generator->setVariables(array(
            'className' => $map->getClassName(),
            'namespace' => $map->getNamespace().'\GeneratedMapping',
            'fields'    => $propertiesNames,
            'imports'   =>  array(),
        ));
        $generator->addBuilder($mapperBuilder);
        $generator->writeOnDisk($this->directory.'/GeneratedMapping');


    }
}