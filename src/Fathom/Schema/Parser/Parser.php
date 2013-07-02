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

        if($this->checkMandatoryDefinitions() && $this->checkRelations()){
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

    public function checkRelations()
    {
        if(array_key_exists('relations', $this->schema)){
            foreach($this->schema['relations'] as $relation => $relschema){
                /** for later
                if(!class_exists($relschema['node'])){
                    throw new \InvalidArgumentException('The node class for relation xxx does not exist');
                }
                */
                if(empty($relschema['node'])){
                    throw new \InvalidArgumentException('The node class for relation xxx does not exist');
                }
            }
        }
        return true;
    }


}