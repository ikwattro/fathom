<?php

/**
 * This file is part of the Fathom package
 *
 * 22/05/13
 * 21:51
 */
 

namespace Fathom\Persistence\Util;



/**
 * 
 * @author Christophe Willemsen <willemsen.christophe@gmail.com>
 *
 */

class BasePeer
{
    public function save($entity, $conn = null)
    {
        $data = $entity->serialize();
        $uuid = $entity->generateUuid();
        $data['uuid'] = $uuid->__toString();
        $q = 'CREATE (n{params}) RETURN n;';
        $params = array('params' => $data);
        try{
            $response = $conn->sendCypherQuery($q, $params);
            $response = json_decode($response, true);
        } catch (\Guzzle\Http\Exception\ErrorResponseException $e){
            throw new \InvalidArgumentException('There was an error during the insert');
        }

        if(is_array($response)){
            $id = $response['data'][0][0]['data']['uuid'];
            $entity->setNeoId($id);
        }
    }

    public function query($query, $conn = null)
    {
        try{
            $response = $conn->sendCypherQuery($query);
            return json_decode($response, true);
        } catch (\Guzzle\Http\Exception\ErrorResponseException $e){
            throw new \InvalidArgumentException('Error when trying to find');
        }
    }



}