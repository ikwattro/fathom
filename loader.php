<?php

//namespace Fathom;

require "vendor/autoload.php";

use Fathom\Schema\SchemaLoader;
use Symfony\Component\Finder\Finder;

$ns = '/home/christophe/workbox/www/basebox/src/Fathom/Play';


$finder = new Finder();
$dir = __DIR__.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $ns).DIRECTORY_SEPARATOR.'Schema';

$finder->files()->name('*.yml')->name('*.yaml')->in($ns);

foreach ($finder as $file){
    echo $file->getFileName()."\n";
}

exit();
$loader = new SchemaLoader();
try{
    $loader->load($file);
} catch(\InvalidArgumentException $e){
    print_r($e->getMessage());
    echo "\n";
}

exit();