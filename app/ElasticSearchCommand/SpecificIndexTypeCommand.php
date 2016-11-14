<?php

namespace CinemaHD\ElasticsearchCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Saxulum\Console\Command\AbstractPimpleCommand;

class SpecificIndexTypeCommand extends AbstractPimpleCommand
{
    private $index_name;
    private $type;

    public function __construct($index_name, $type)
    {
        $this->index_name = $index_name;
        $this->type       = $type;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("index:{$this->index_name}:{$this->type}")
             ->setDescription("Indexing elasticsearch for {$this->index_name}/{$this->type}")
             ->addOption('reset', null, null, 'Do you want to reset the index first?')
             ->addOption('id', null, InputOption::VALUE_OPTIONAL, 'Id of the entity to index')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app   = $this->container;
        $reset = $input->getOption("reset");
        $id    = $input->getOption("id");

        if (isset($id)) {
            try {
                $output->writeln("<info>Indexing {$this->index_name}:{$this->type} {$id}...</info>");
                $app["elasticsearch.{$this->index_name}.index_one"]($this->type, $id);
                $output->writeln("<info>done</info>");
            } catch (\Exception $exception) {
                $output->writeln("<error>Exception occured : {$exception->getMessage()}</error>");
            }
        } else {
            $app['elasticsearch.create_type']($this->index_name, $this->type, $reset);
            $app["elasticsearch.cinemahd.reindex"]([$this->type]);
        }
    }
}
