<?php

//namespace Fathom;

require "vendor/autoload.php";

use Fathom\Schema\Parser\Parser;
use Fathom\Fathom;
use Symfony\Component\Yaml\Yaml;
use Fathom\Builder\Builder;
use Fathom\Builder\Generator\NodeGenerator;
use Fathom\Play\SimpleNode;
use Neoxygen\Navdis\Client\Client;
use Fathom\Persistence\Manager\Manager;


$node = new SimpleNode();
$node->setUsername('chris');
$node->setKlout(43);
$node->setTimestamp(time());

$ser = $node->serialize();
print_r($ser);

$query = 'CREATE (n{params}) RETURN n';
$cypher = array('query'=>$query, 'params'=>$ser);

$shakeQuery = "CREATE shakespeare = { firstname : 'William', lastname : 'Shakespeare' },
juliusCaesar = { title : 'Julias Caesar' },
(shakespeare)-[:WROTE { date : 1599 }]->(juliusCaesar),
theTempest = { title : 'The Tempest' },
(shakespeare)-[:WROTE { date : 1610}]->(theTempest),
rsc = { company : 'Royal Shakespeare Company' },
production1 = { production : 'Julius Caesar' },
(rsc)-[:PRODUCED]->(production1),
(production1)-[:PRODUCTION_OF]->(juliusCaesar),
performance1 = { performance : 20120729 },
(performance1)-[:PERFORMANCE_OF]->(production1),
production2 = { production : 'The Tempest' },
(rsc)-[:PRODUCED]->(production2),
(production2)-[:PRODUCTION_OF]->(theTempest),
performance2 = { performance : 20061121 },
(performance2)-[:PERFORMANCE_OF]->(production2),
performance3 = { performance : 20120730 },
(performance3)-[:PERFORMANCE_OF]->(production1),
billy = { user : 'Billy' },
rating = { rating: 5, review : 'This was awesome!' },
(billy)-[:WROTE]->(rating),
(rating)-[:RATED]->(performance1),
theatreRoyal = { theatre : 'Theatre Royal' },
(performance1)-[:VENUE]->(theatreRoyal),
(performance2)-[:VENUE]->(theatreRoyal),
greyStreet = { street : 'Grey Street' },
(theatreRoyal)-[:IN]->(greyStreet),
newcastle = { city : 'Newcastle' },
(greyStreet)-[:IN]->(newcastle),
tyneAndWear = { county: 'Tyne and Wear' },
(newcastle)-[:IN]->(tyneAndWear),
uk = { country: 'United Kingdom' },
(tyneAndWear)-[:IN]->(uk),
stratford = { town : 'Stratford upon Avon' },
(stratford)-[:IN]->(uk),
(rsc)-[:BASED_IN]->(stratford)
";

$conn = new Client();
$response = $conn->sendCypherQuery($query, $ser);

// Trying with the Manager

$manager = new Manager();
$manager->persist($node);
print_r($manager->getLastMsg());