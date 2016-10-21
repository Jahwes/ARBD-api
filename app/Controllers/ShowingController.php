<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Showing;

class ShowingController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/showings', [$this, 'getShowings']);

        $controllers->get('/showings/{showing}', [$this, 'getShowing'])
            ->assert("showing", "\d+")
            ->convert("showing", $app["findOneOr404"]('Showing', 'id'));

        $controllers->get('/showings/{showing}/tickets', [$this, 'getShowingTickets'])
            ->assert("showing", "\d+")
            ->convert("showing", $app["findOneOr404"]('Showing', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les showings
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getShowings(Application $app)
    {
        $showings = $app["repositories"]("Showing")->findAll();

        return $app->json($showings, 200);
    }

    /**
     * Récupère un showing via son ID
     *
     * @param  Application $app        Silex application
     * @param  Showing     $showing    L'entité du showing
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getShowing(Application $app, Showing $showing)
    {
        return $app->json($showing, 200);
    }

    /**
     * Récupère les tickets associés à un showing via son ID
     *
     * @param  Application $app        Silex application
     * @param  Showing     $showing    L'entité du showing
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getShowingTickets(Application $app, Showing $showing)
    {
        $showing_tickets = $app["repositories"]("Ticket")->findByShowing($showing);

        return $app->json($showing_tickets, 200);
    }
}
