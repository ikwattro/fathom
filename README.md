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

The files will be generated under the `src/Acme/GeneratedMapping` folder:

````
Validating Mapping File "SimpleNode.yml"...
Mapping file SimpleNode.yml validated
Validating Mapping File "Flag.yml"...
Mapping file Flag.yml validated
All files validated, starting mapping generation ...
````