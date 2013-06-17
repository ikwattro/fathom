<?php

namespace Fathom\Mapper;

use Lootils\Uuid\Uuid;
use Fathom\Persistence\Util\BasePeer;

class BaseMapper
{
    public function save($conn = null)
    {
        //$uuid = Uuid::createV4();
        //$data = $this->serialize();
        //$data['uuid'] = $uuid->__toString();
        //$peer = new BasePeer();
        //$id = $peer->save($data, $conn);
        //$response = json_decode($id, true);
        //$rdata = $response['data'][0][0]['data'];
        //$this->setUuid($rdata['uuid']);
        $peer = new BasePeer();
        $peer->save($this, $conn);
    }

    public function generateUuid()
    {
        $uuid = Uuid::createV4();
        return $uuid;
    }
}