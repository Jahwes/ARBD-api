<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Type;

class TypeController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/types', [$this, 'getTypes']);

        return $controllers;
    }


    /**
     * Récupère tous les types
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTypes(Application $app)
    {
        $types = $app["repositories"]("Type")->findAll();

        return $app->json($types, 200);
    }
}
