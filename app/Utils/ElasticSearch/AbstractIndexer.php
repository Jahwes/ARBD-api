<?php

namespace CinemaHD\Utils\Elasticsearch;

use Silex\Application;

abstract class AbstractIndexer
{
    protected $app;
    protected $name;

    /**
     * @param Application $app
     */
    public function __construct(Application $app, $name)
    {
        $this->app  = $app;
        $this->name = $name;

        $this->app["elasticsearch.{$name}.reindex"]         = [$this, 'reindex'];
        $this->app["elasticsearch.{$name}.index_one"]       = [$this, 'indexOne'];
        $this->app["elasticsearch.{$name}.put_document"]    = [$this, 'putDocument'];
        $this->app["elasticsearch.{$name}.remove_document"] = [$this, 'removeDocument'];
    }

    public function indexOne($type, $id)
    {
        if (false === in_array($type, $this->app["elasticsearch.{$this->name}.types"])) {
            throw new \Exception("Invalid type {$type} for index {$this->name}");
        }
        $index_one_func_name = "indexOne" . implode('', array_map('ucfirst', explode('_', $type)));
        if (!method_exists($this, $index_one_func_name)) {
            throw new \Exception("Implement the method {$index_one_func_name} as protected to index one type {$type}");
        }
        $this->{$index_one_func_name}($id);
    }

    /**
     * @return void
     */
    public function reindex($types = [])
    {
        if (!empty($invalid_types = array_diff($types, $this->app["elasticsearch.{$this->name}.types"]))) {
            throw new \Exception("Invalid type(s) " . implode(', ', $types) . " for index {$this->name}");
        }

        if (empty($types)) {
            $types = $this->app["elasticsearch.{$this->name}.types"];
        }

        foreach ($types as $type) {
            $index_func_name = "index" . implode('', array_map('ucfirst', explode('_', $type)));
            if (!method_exists($this, $index_func_name)) {
                throw new \Exception("Implement the method {$index_func_name} as protected to index type {$type}");
            }
            $this->{$index_func_name}();
        }
    }

    /**
     * @return void
     */
    abstract public function removeDocument($type);
}
