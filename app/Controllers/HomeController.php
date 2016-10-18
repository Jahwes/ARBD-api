<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/', [$this, 'index']);

        return $controllers;
    }

    public function index(Application $app)
    {
        $test = [
            "Bonjour"        => "Je suis un test",
            "Hello"          => 4242,
            "Cinema"         => "du turfu",
            "Plein de trucs" => [
                "un truc"     => 1,
                "deux trucs"  => "bonjour",
                "trois trucs" => 4938475
            ]
        ];

        return $app->json($test, 200);
    }
}
