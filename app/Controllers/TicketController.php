<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Ticket;

class TicketController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/tickets', [$this, 'getTickets']);

        $controllers->get('/tickets/{ticket}', [$this, 'getTicket'])
            ->assert("ticket", "\d+")
            ->convert("ticket", $app["findOneOr404"]('Ticket', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les tickets
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTickets(Application $app)
    {
        $tickets = $app["repositories"]("Ticket")->findAll();

        return $app->json($tickets, 200);
    }

    /**
     * Récupère un ticket via son ID
     *
     * @param  Application   $app          Silex application
     * @param  Ticket        $ticket       L'entité du ticket
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTicket(Application $app, Ticket $ticket)
    {
        return $app->json($ticket, 200);
    }
}
