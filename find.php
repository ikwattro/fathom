<?php

//namespace Fathom;

require "vendor/autoload.php";

use Neoxygen\Navdis\Client\Client;
use Fathom\Query\Query;

$client = new Client();

$fqdn = 'Fathom\\\\Play\\\\SimpleNode';
$uuid = '6d84d8cc-0335-0636-b21d-f392a9fc8f62';

$query = 'START n=node:node_auto_index(fqdn="'.$fqdn.'") WHERE (n.uuid="'.$uuid.'") RETURN n';
print($query);

print_r($client->sendCypherQuery($query));
exit();
$q = new Query();
$q->start($fqdn, 'n');
$q->where('uuid', $uuid);
$query = $q->getQuery();

$node = $client->sendCypherQuery($query);

$n = new Query();
$n->start($fqdn, 'n')
    ->where('uuid', $uuid)
    ->andWhere('username', 'chris');

print_r($n->getQuery());


$no = $client->sendCypherQuery($n->getQuery());
print_r($no);
