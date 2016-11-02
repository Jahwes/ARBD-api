<?php

namespace CinemaHD\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Saxulum\Console\Command\AbstractPimpleCommand;

class IndexCommand extends AbstractPimpleCommand
{
    protected function configure()
    {
        $this->setName("index")
             ->setDescription("Indexing elasticsearch indexes")
             ->addOption("index-name", "i", InputOption::VALUE_OPTIONAL, "Name of the index")
             ->addOption("reset", null, null, "Do you want to reset the index first?")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app        = $this->container;
        $reset      = $input->getOption("reset");
        $index_name = $input->getOption("index-name");

        $index_names = isset($index_name) ? [$index_name] : $app["elasticsearch.names"];
        foreach ($index_names as $index_name) {
            $output->writeln("<info>Indexing {$index_name}...</info>");
            $app['elasticsearch.create_index']($index_name, $reset);
            $app["elasticsearch.{$index_name}.reindex"]();
        }
    }
}
