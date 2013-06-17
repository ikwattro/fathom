<?php

namespace Fathom\Schema\Parser;

use Symfony\Component\Yaml\Yaml;

class Parser
{
    protected $schema;

    protected $definitions = array(
        'class',
        'fields',
        'auto_id',
        );

    public function parse($schema){
        
        $this->schema = Yaml::parse($schema);

        if($this->checkMandatoryDefinitions()){
            return $this->schema;
        } return false;
    }

    public function checkMandatoryDefinitions()
    {
        foreach($this->definitions as $key=>$definition){
            if(!array_key_exists($definition, $this->schema)){
                throw new \InvalidArgumentException('The definition '.$definition.' is not defined in the schema');
            }
        }
        return true;
    }


}