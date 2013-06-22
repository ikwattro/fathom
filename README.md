# [WIP] Fathom - A Neo4j PHP Mapper

## Installation

* Fork the repository and install the dependencies with `composer install`

## Defining your schema

Fathom makes use of the `yaml` format for schema definition, the readibility of the schema is easy, let's take a look :

````
#SimpleNode
class: Fathom\Play\SimpleNode
auto_id: ~
fields:
    username:
        type: string
        length: 255
    klout:
        type: integer
        negative: false
    timestamp:
        type: integer
        negative: false
````

The `class` keyword is used to define your namespace, the `auto_id` keyword is set to default, currently it uses a v4 uuid to define the nodes id, this should evolve to multiple and custom id generators.

## Building your mapping files

There is a CLI tool available to build your mapping files based on the schema.

`bin/fathom generate:mapping`

The interactive console will prompt you to enter the path to your schema folder, let's say it is under the `src/Acme/Schema` folder, you can just enter `src/Acme`.


````
Validating Mapping File "SimpleNode.yml"...
Mapping file SimpleNode.yml validated
Validating Mapping File "Flag.yml"...
Mapping file Flag.yml validated
All files validated, starting mapping generation ...
````

There will be two kinds of files generated, first a Node Entity extending the NodeMapper, the NodeEntity is made for you to add custom logic, the Node Mapper contains generated methods and cannot be modified.

Second, the NodeQuery extending also a generic NodeQuery class, this class is used for querying the database.

The generic files are stored under the src/xxx/GeneratedMapping folder.

## Using the mappers

In order to use the mappers, you need a connection to the Neo4j database. This is include currently in this package, however it should be decoupled later

````
require "vendor/autoload.php";

use Neoxygen\Navdis\Client\Client as NClient;

$conn = new NClient();

````

You can use the mappers to handle your data :

````
require "vendor/autoload.php";

use Neoxygen\Navdis\Client\Client as NClient;
use Fathom\Play\SimpleNode;
use Fathom\Play\SimpleNodeQuery;

$conn = new NClient();

// Creating a new SimpleNode instance, setting values and saving to the database

$node = new SimpleNode();
$node->setUsername('john doe');
$node->setKlout(43);
$node->save();

// The generated id is now available:
echo $node->getId();


// Retrieving nodes from the database

$q = new SimpleNodeQuery($conn);
$node = $q->findById("f990d04b-3848-03fc-8772-d000e6276faa");

````