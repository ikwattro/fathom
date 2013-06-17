<?php

//namespace Fathom;

require "vendor/autoload.php";

use Guzzle\Http\Client;
use Neoxygen\Navdis\Client\Client as NClient;

// reading data
/**
$client = new Client('http://localhost:7474');
$request = $client->get('/db/data');

$response = $request->send();

$data = $response->json();
//print_r($data);


// fetching data

$client = new Client('http://localhost:7474');
$query = "START n=node(0) return n;";
$request = $client->post('/db/data/cypher');
$body = array('query' => $query);
$js = json_encode($body);
$request->setBody($js, 'application/json');

$response = $request->send();
//print_r($response->getBody(true));

//exit();


// inserting data

$multiple = array();
$multiple[] = array('username'=>'me', 'tstamp' => time());
$multiple[] = array('username'=>'bobo', 'tstamp' => microtime());

//$body = array();
$query = "CREATE (n{params}) RETURN n;";
$params = array('username'=>'chris');
$body = array('query' => $query);
$body['params'] = array('params'=>$multiple);

$json = json_encode($body);



$client = new Client('http://localhost:7474');
$request = $client->post('/db/data/cypher');
$request->setHeader('Content-Type', 'application/json');
$request->setHeader('Accept', 'application/json');
$request->setBody($json, 'application/json');

try{
    $response = $request->send();
} catch(Guzzle\Http\Exception\BadResponseException $e){
    print_r($e->getResponse()->getBody(true));
}

//print_r($response->getBody(true));

// Test with the Guzzle Http Client
*/
$nclient = new NClient();
//$resp = $nclient->sendCypherQuery($query, $multiple);
//print_r($resp);

// Create with relation

$q = 'CREATE c = (n{params})-[:WORKS_AT]->(i{google}) RETURN c,n,i;';
$params = array('params' => array('name' => 'christophe', 'function' => 'cis'), 'google' => array('name' => 'M923 Narcis', 'class' => 'Flower Class', 'CallSign' => 'ORGN'));
//$google = array('name' => 'M923 Narcis', 'class' => 'Flower Class', 'CallSign' => 'ORGN');
$resp = $nclient->sendCypherQuery($q, $params);
print_r($resp);
