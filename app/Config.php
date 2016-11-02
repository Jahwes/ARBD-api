<?php

namespace CinemaHD;

use Silex\Application;
use Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Silex\Provider\DoctrineServiceProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\Console\Provider\ConsoleProvider;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;

use CinemaHD\Utils\Elasticsearch\Elasticsearch;
use CinemaHD\Utils\Elasticsearch\CinemaHDElasticsearchIndexer;

use CinemaHD\ElasticsearchCommand\SpecificIndexCommand;
use CinemaHD\ElasticsearchCommand\SpecificIndexTypeCommand;

/**
 * Configuration principale de l'application
 */
class Config implements ServiceProviderInterface
{
    private $env = "production";

    public function __construct($env = null)
    {
        if (null !== $env) {
            $this->env = $env;
            if (true === file_exists(__DIR__ . "/Env/{$this->env}.php")) {
                require_once __DIR__ . "/Env/{$this->env}.php";
            }
        }
    }

    /**
     * @{inherit doc}
     */
    public function register(Container $app)
    {
        $this->registerEnvironmentParams($app);
        $this->registerServiceProviders($app);
        $this->registerRoutes($app);
        $app->after($app["cors"]);
    }

    /**
     * Set up environmental variables
     *
     * @param Application $app Silex Application
     *
     */
    private function registerEnvironmentParams(Application $app)
    {
        include "Utils/Silex/Middlewares.php";

        $app['version'] = '1.0.0';
        $app['locale']  = 'fr';

        $app['application_name']      = 'cinemahd-api';
        $app['application_env']       = $this->env;
        $app['application_path']      = realpath(__DIR__ . "/../");
        $app['application_namespace'] = __NAMESPACE__;

        $app['db_host']     = getenv("CINEMAHD_DATABASE_HOST");
        $app['db_name']     = getenv("CINEMAHD_DATABASE_NAME");
        $app['db_user']     = getenv("CINEMAHD_DATABASE_USER");
        $app['db_password'] = getenv("CINEMAHD_DATABASE_PWD");

        $app["elasticsearch_cinemahd_parameters_path"] = realpath(
            __DIR__ . "/Utils/Elasticsearch/CinemaHDParameters"
        );

        switch ($app['application_env']) {
            case 'production':
                ini_set('display_errors', false);
                $app['controllers']->requireHttps();
                break;

            default:
                ini_set('display_errors', true);
                ini_set('xdebug.var_display_max_depth', 100);
                ini_set('xdebug.var_display_max_children', 100);
                ini_set('xdebug.var_display_max_data', 100);
                error_reporting(E_ALL);
                $app["debug"] = true;
                break;
        }
    }

    /**
     * Register Silex service providers
     *
     * @param  Application $app Silex Application
     */
    private function registerServiceProviders(Application $app)
    {
        $app->register(new Provider\ServiceControllerServiceProvider());

        if ($app['debug']) {
            $app->register(new DebugConfig());
        }

        $app->register(new DoctrineServiceProvider());
        $app->register(new DoctrineOrmServiceProvider());
        $app->register(new ConsoleProvider());
        $app->register(new DoctrineOrmManagerRegistryProvider());
        $app->register(new CorsServiceProvider());


        // Doctrine (db)
        $app['db.options'] = [
            'driver'   => 'pdo_mysql',
            'charset'  => 'utf8',
            'host'     => $app['db_host'],
            'dbname'   => $app['db_name'],
            'user'     => $app['db_user'],
            'password' => $app['db_password'],
        ];

        // Doctrine (orm)
        $app['orm.proxies_dir']   = $app['application_path'] . '/cache/doctrine/proxies';
        $app['orm.default_cache'] = 'array';
        $app['orm.em.options']    = [
            'mappings' => [
                [
                    'type'      => 'annotation',
                    'path'      => $app['application_path'] . '/app',
                    'namespace' => "{$app['application_namespace']}\\Entities",
                ],
            ],
        ];

        // Connect repositories
        // do $app["repositories"]("MyClass") instead of $app["orm.em"]->getRepository("MyClass")
        $app["repositories"] = $app->protect(
            function ($repository_name) use ($app) {
                $class_name = "\\{$app['orm.em.options']['mappings'][0]['namespace']}\\". $repository_name;
                if (class_exists($class_name)) {
                    return $app['orm.em']->getRepository($class_name);
                }
                return null;
            }
        );

        $app['console.command.paths'] = $app->extend('console.command.paths', function ($paths) {
            $paths[] = __DIR__ . '/Command';

            return $paths;
        });

        $app['console.commands'] = $app->extend('console.commands', function ($commands) {
            return $commands;
        });

        $app["elasticsearch.cinemahd.indexer"] = new CinemaHDElasticsearchIndexer($app);
        $app->register(new Elasticsearch(['cinemahd']));

        $app['console.commands'] = $app->extend('console.commands', function ($commands) use ($app) {
            // Ajout des commandes Elasticsearch
            foreach ($app["elasticsearch.names"] as $index_name) {
                $command = new SpecificIndexCommand($index_name);
                $command->setContainer($app);
                $commands[] = $command;
                foreach ($app["elasticsearch.{$index_name}.types"] as $type) {
                    $command = new SpecificIndexTypeCommand($index_name, $type);
                    $command->setContainer($app);
                    $commands[] = $command;
                }
            }

            return $commands;
        });


        $platform = $app["orm.em"]->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Mount all controllers and routes
     *
     * @param  Application $app Silex Application
     *
     */
    private function registerRoutes(Application $app)
    {
        // Recherche tous les controllers pour les loader dans $app
        foreach (glob(__DIR__ . "/Controllers/*.php") as $controller_name) {
            $controller_name = pathinfo($controller_name)["filename"];
            $class_name      = "\\CinemaHD\\Controllers\\{$controller_name}";
            if (class_exists($class_name)
                && in_array("Silex\Api\ControllerProviderInterface", class_implements($class_name))
            ) {
                $app[$controller_name] = function () use ($class_name) {
                    return new $class_name();
                };
                $app->mount('/', $app[$controller_name]);
            }
        }
    }
}
