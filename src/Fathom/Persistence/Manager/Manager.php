<?php

namespace Fathom\Persistence\Manager;

use Neoxygen\Navdis\Client\Client;
use Lootils\Uuid\Uuid;

class Manager
{
    protected $client;

    protected $lastMsg;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function persist($object)
    {
        $data = $object->serialize();
        $data['fqdn'] = $object->getNamespace().'\\'.$object->getClassName();
        if(!array_key_exists('uuid', $data)){
            $this->save($data);
        } else {
            $this->update($data);
        }
    }

    public function save($data)
    {
        $uuid = Uuid::createV4();
        $data['uuid'] = $uuid->__toString();
        var_dump($data);
        $query = 'CREATE (n{params}) RETURN n';
        $resp = $this->client->sendCypherQuery($query, $data);
        $this->lastMsg = $resp;
    }

    public function getLastMsg()
    {
        return $this->lastMsg;
    }

}