<?php

namespace Neoxygen\Navdis\Client;

use Guzzle\Http\Client as BaseClient;

class Client
{

    private $query;

    private $params;

    public function sendCypherQuery($query, array $params = array())
    {
        $this->query = $query;
        print_r($query);
        $this->params = $params;
        $client = new BaseClient('http://localhost:7474');
        $client->setDefaultHeaders(array(
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/json'
));

        $request = $client->post('db/data/cypher');
        $request->setBody($this->getEncodedQuery(), 'application/json');

        try{
            $response = $request->send();
            return $response->getBody(true);
        } catch(\Guzzle\Http\Exception\ClientErrorResponseException $e){
            return $e->getMessage();
        }
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getEncodedQuery()
    {
        $query = $this->buildBody();
        return json_encode($query);
    }

    private function buildBody()
    {
        $body = array('query' => $this->query);
        if(null != $this->getParams()){
            $body['params'] = $this->getParams();
        }
        return $body;
    }
}