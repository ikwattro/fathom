<?php

namespace Fathom\Console\Command;

use Buzz\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

use Fathom\Schema\Parser\Parser;
use Fathom\Schema\Schema;
use Fathom\Builder\Builder;
use Fathom\Builder\Generator\NodeGenerator;

class MapperGeneratorCommand extends Command{

    protected function configure()
    {
        $this
            ->setName('generate:mapping')
            ->setDescription('Generate Neo4j Mapping')
            ->addArgument(
                'namespace',
                InputArgument::OPTIONAL,
                'The entity namespace of your mapping?'
            )
            ->addOption(
                'no-backup',
                null,
                InputOption::VALUE_NONE,
                'If set, the generator will not backup previous generated files'
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $namespace = $dialog->askAndValidate(
            $output,
            'Please enter the path to your schema folder:'."\n",
            function ($answer){
                $expl = explode(':', $answer);
                if (null == realpath($expl[0])){
                    $cwd = getcwd();
                    $ds = DIRECTORY_SEPARATOR;
                    $path = $cwd.$ds.$expl[0];
                    throw new \RuntimeException('The path '.$path.' could not be found');
                }
                if (count($expl) > 1){
                    $entity = $expl[1];
                    $directory = realpath($expl[0]).DIRECTORY_SEPARATOR.'Schema';
                    $finder = new Finder();
                    $finder->files()->name($entity.'.yml')->in($directory);
                    if (count($finder) < 1){
                        throw new \RuntimeException('The file \''.$entity.'.yml\' can not be found in the folder \''.$directory.'\'');
                    }
                }
                $directory = realpath($expl[0]).DIRECTORY_SEPARATOR.'Schema';
                $finder = new Finder();
                $finder->files()->name('*.yml')->name('*.yaml')->in($directory);
                if (count($finder) < 1){
                    throw new \RuntimeException('No schema files were found in the specified directory');
                }
                return $answer;
            },
            false
        );

        $expl = explode(':', $namespace);

        $finder = new Finder();
        $directory = realpath($expl[0]).DIRECTORY_SEPARATOR.'Schema';
        $entityDirectory = realpath($expl[0]);

        $mappingFiles = array();
        $fileWildcard = isset($expl[1]) ? $expl[1] : '*';

        $finder->files()->name($fileWildcard.'.yml')->name($fileWildcard.'yaml')->in($directory);
            foreach ($finder as $file){
                $schema = new Schema();
                $schema->setFilepath($file->getRealpath());
                $schema->setFilename($file->getFilename());
                $mappingFiles[] = $schema;
            }

        $parser = new Parser();
        $errors = array();
        $maps = array();

        foreach($mappingFiles as $file){
            $output->writeln('<comment>Validating Mapping File "'.$file->getFilename().'"...');
            try {
                @$yaml = $parser->parse($file->getFilepath());
                $output->writeln('<info>Mapping file '.$file->getFilename().' validated</info>');
                $file->setYamlSchema($yaml);
            } catch (\InvalidArgumentException $e) {
                $errors[] = array(
                    'file'  => $file->getFilename(),
                    'error' => $e->getMessage(),
                );
            }
        }
        if (0 !== count($errors)){
            $output->writeln('<error>'."\n".'Please correct the following errors before the mapping can be generated :</error>');
            $output->writeln('<error>-------------------------------------------------------------------------'."\n".'</error>');
            foreach ($errors as $error){
                $output->writeln('<error>Mapping file "'.$error['file'].'" is not valid :'."\n".$error['error'].'</error>');
            }
        } else {
            $output->writeln('<info>All files validated, starting mapping generation ...</info>');
            foreach($mappingFiles as $file){
                $map = new Builder($file->getYamlSchema());
                $gen = new NodeGenerator($entityDirectory);
                $gen->generateNode($map);
            }

        }
    }

}