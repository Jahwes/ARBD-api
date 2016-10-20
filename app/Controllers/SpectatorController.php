<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Spectator;

class SpectatorController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/spectators', [$this, 'getSpectators']);

        $controllers->get('/spectators/{spectator}', [$this, 'getSpectator'])
            ->assert("spectator", "\d+")
            ->convert("spectator", $app["findOneOr404"]('Spectator', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les spectators
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getSpectators(Application $app)
    {
        $spectators = $app["repositories"]("Spectator")->findAll();

        return $app->json($spectators, 200);
    }

    /**
     * Récupère un spectator via son ID
     *
     * @param  Application   $app          Silex application
     * @param  Spectator     $Spectator    L'entité du spectator
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getSpectator(Application $app, Spectator $spectator)
    {
        return $app->json($spectator, 200);
    }
}
