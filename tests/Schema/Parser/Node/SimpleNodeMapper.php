<?php

namespace Fathom\tests\Schema\Parser\Node;

class SimpleNodeMapper
{
    public function serialize()
    {
        $data = array();
        if(null !== $this->username){
            $data[username] = $this->getUsername;
        }
        if(null !== $this->klout){
            $data[klout] = $this->getKlout;
        }
        return $data;
    }
}