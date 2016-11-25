<?php

namespace CinemaHD\ElasticSearchCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Saxulum\Console\Command\AbstractPimpleCommand;

class SpecificIndexCommand extends AbstractPimpleCommand
{
    private $index_name;

    public function __construct($index_name)
    {
        $this->index_name = $index_name;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("index:{$this->index_name}")
             ->setDescription("Indexing elasticsearch for {$this->index_name}")
             ->addOption("reset", null, null, "Do you want to reset the index first?")
             ->addOption("type", "t", InputOption::VALUE_OPTIONAL, "Type to reindex")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app   = $this->container;
        $reset = $input->getOption("reset");
        $type  = $input->getOption("type");

        if (isset($type)) {
            $output->writeln("<info>Indexing {$this->index_name}:{$type}...</info>");
            $app['elasticsearch.create_type']($this->index_name, $type, $reset);
            $app["elasticsearch.cinemahd.reindex"]([$type]);
        } else {
            $output->writeln("<info>Indexing {$this->index_name}...</info>");
            $app['elasticsearch.create_index']($this->index_name, $reset);
            $app["elasticsearch.cinemahd.reindex"]();
        }
    }
}
