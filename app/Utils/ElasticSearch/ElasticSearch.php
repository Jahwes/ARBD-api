<?php

namespace CinemaHD\Utils\ElasticSearch;

use Silex\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
*
*/
class ElasticSearch implements ServiceProviderInterface
{
    private $es_options;
    private $app;

    /**
     * @param null|string[] $es_options
     */
    public function __construct(array $es_options = null)
    {
        $es_options = $es_options ?: [
            "default",
        ];

        $this->es_options = [];
        foreach ($es_options as $db_name) {
            $name                = strtoupper($db_name);
            $elasicsearch_host   = getenv("{$name}_ELASTICSEARCH_HOST");
            $elasticsearch_types = getenv("{$name}_ELASTICSEARCH_TYPES");
            if (false === $elasicsearch_host) {
                throw new \Exception("{$name}_ELASTICSEARCH_HOST doesn't exist");
            }
            if (false === $elasticsearch_types) {
                throw new \Exception("{$name}_ELASTICSEARCH_TYPES doesn't exist");

            }
            $this->es_options[$db_name] = [
                "host"  => $elasicsearch_host,
                "types" => explode(',', $elasticsearch_types)
            ];
        }
    }

    /**
     *
     * @{inherit doc}
     */
    public function register(Container $app)
    {
        $this->app = $app;

        if (!isset($app["application_path"])) {
            throw new \Exception('$app["application_path"] is not set');
        }

        $app["elasticsearch.names"] = array_keys($this->es_options);
        foreach ($this->es_options as $name => $es_option) {
            // On vérifie qu'on a bien un indexer
            if (false === isset($app["elasticsearch.{$name}.indexer"]) ||
                false === is_subclass_of($app["elasticsearch.{$name}.indexer"], "CinemaHD\Utils\Elasticsearch\AbstractIndexer")) {
                throw new \Exception('You must provide $app["elasticsearch.{$name}.indexer"] see AbstractIndexer');
            }

            $parsed_url = parse_url($es_option['host']);
            $index      = ltrim($parsed_url['path'], '/');

            $app["elasticsearch.{$name}.server"] = str_replace($parsed_url['path'], '', $es_option['host']) . "/";
            $app["elasticsearch.{$name}.index"]  = $index;
            $app["elasticsearch.{$name}.types"]  = $es_option['types'];

            $app["elasticsearch.{$name}"] = \Elasticsearch\ClientBuilder::create()
                ->setHosts([$app["elasticsearch.{$name}.server"]])
                ->build();
        }

        $app['elasticsearch.create_index'] = [$this, 'createIndex'];
        $app["elasticsearch.create_type"]  = [$this, 'createType'];
        $app['elasticsearch.lock']         = [$this, 'lock'];
        $app['elasticsearch.unlock']       = [$this, 'unlock'];
    }

    public function createIndex($name, $reset = false)
    {
        $app = $this->app;

        if (!in_array($name, $app["elasticsearch.names"])) {
            throw new \Exception("Application is not configured for index {$name}");
        }

        if (!isset($app["version"])) {
            throw new \Exception('$app["version"] is not set');
        }

        if (true === $reset) {
            echo "\nCreating elasticsearch index... {$app["elasticsearch.$name.index"]}\n";
            $this->unlock($name);

            // On supprime l'index
            try {
                $app["elasticsearch.{$name}"]->indices()->delete(
                    ["index" => "{$app["elasticsearch.$name.index"]}-{$app["version"]}"]
                );
            } catch (\Exception $exception) {
                echo "Index {$app["elasticsearch.$name.index"]}-{$app["version"]} doesn't exist... \n";
            }

            $parameters_path = $app["elasticsearch_{$name}_parameters_path"];
            // On récupère les settings et les mappings pour créer l'index
            $settings = json_decode(file_get_contents("$parameters_path/settings.json"), true);

            $index_params = [
                "index" => "{$app["elasticsearch.$name.index"]}-{$app["version"]}",
                "body"  => ["settings" => $settings]
            ];
            // Création de l'index
            $app["elasticsearch.$name"]->indices()->create($index_params);

            // Rajout de l'alias
            $alias = [
                "index" => "{$app["elasticsearch.$name.index"]}-{$app["version"]}",
                "name"  => $app["elasticsearch.{$name}.index"]
            ];

            try {
                $app["elasticsearch.{$name}"]->indices()->deleteAlias($alias);
            } catch (\Exception $e) {
                echo "Alias doesn't exist... \n";
            }
            $app["elasticsearch.{$name}"]->indices()->putAlias($alias);

            echo "Index {$app["elasticsearch.$name.index"]} created successfully!\n\n";

            foreach ($app["elasticsearch.{$name}.types"] as $type) {
                self::createType($name, $type, $reset);
            }
        }
    }

    public function createType($name, $type, $reset = false)
    {
        $app = $this->app;

        if (!in_array($name, $app["elasticsearch.names"])) {
            throw new \Exception("Application is not configured for index {$name}");
        }

        if (!in_array($type, $app["elasticsearch.{$name}.types"])) {
            throw new \Exception("Application is not configured for type {$app["elasticsearch.$name.index"]}/{$type}");
        }

        if (true === $reset) {
            echo "\nCreating elasticsearch type {$type} for index {$app["elasticsearch.$name.index"]}\n";

            $parameters_path = $app["elasticsearch_{$name}_parameters_path"];
            if (!file_exists("{$parameters_path}/{$type}-mapping.json")) {
                throw new \Exception("Mapping file for type {$type} does not exist");
            }
            $mapping = json_decode(file_get_contents("{$parameters_path}/{$type}-mapping.json"), true);

            $this->unlock($name);

            try {
                $app["elasticsearch.{$name}"]->indices()->deleteMapping([
                    "index" => $app["elasticsearch.{$name}.index"],
                    "type"  => $type
                ]);
            } catch (\Exception $exception) {
                echo "Type {$app["elasticsearch.$name.index"]}/{$type} doesn't exist... \n";
            }

            $app["elasticsearch.{$name}"]->indices()->putMapping([
                "index" => $app["elasticsearch.{$name}.index"],
                "type"  => $type,
                "body"  => $mapping
            ]);

            echo "Type {$app["elasticsearch.$name.index"]}/{$type} created successfully!\n\n";
        }
    }

    public function lock($name)
    {
        $this->lockOrUnlockElasticSearch($name, "lock");
    }

    public function unlock($name)
    {
        $this->lockOrUnlockElasticSearch($name, "unlock");
    }

    /**
     * Bloque ou débloque les écritures sur l'elasticsearch
     *
     * @param string $action "lock" ou "unlock" pour faire l'action qui porte le même nom
     */
    private function lockOrUnlockElasticSearch($name, $action)
    {
        switch (true) {
            case false === isset($this->app):
            case false === isset($this->app["elasticsearch.{$name}.server"]):
            case false === isset($this->app["elasticsearch.{$name}.index"]):
                throw new \Exception(__METHOD__ . "::{$action}: Missing parameter");
        }

        $action = ("lock" === $action) ? "true" : "false";

        $server = $this->app["elasticsearch.{$name}.server"] . $this->app["elasticsearch.{$name}.index"];
        exec(
            "curl -XPUT '" . $server . "/_settings' -d '
            {
                \"index\" : {
                    \"blocks.read_only\" : {$action}
                }
            }
            ' 2> /dev/null"
        );
    }
}
