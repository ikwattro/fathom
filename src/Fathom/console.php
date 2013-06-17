<?php

set_time_limit(0);

$application = new \Symfony\Component\Console\Application('Fathom Console', '1.0.0');
$application->add(new \Fathom\Console\Command\MapperGeneratorCommand('generate:mapping'));
$application->run();