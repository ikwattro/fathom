<?php

//namespace Fathom;

require "vendor/autoload.php";

use Neoxygen\Navdis\Client\Client as NClient;
use Fathom\Play\SimpleNode;
use Fathom\Play\SimpleNodeQuery;

$conn = new NClient();

$q = new SimpleNodeQuery($conn);
$node = $q->findById("f990d04b-3848-03fc-8772-d000e6276faa");

print_r($node);
