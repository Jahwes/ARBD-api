<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Order;

class OrderController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/orders', [$this, 'getOrders']);

        $controllers->get('/orders/{order}', [$this, 'getOrder'])
            ->assert("order", "\d+")
            ->convert("order", $app["findOneOr404"]('Order', 'id'));

        $controllers->get('/orders/{order}/tickets', [$this, 'getTicketsForOrder'])
            ->assert("order", "\d+")
            ->convert("order", $app["findOneOr404"]('Order', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les orders
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOrders(Application $app)
    {
        $orders = $app["repositories"]("Order")->findAll();

        return $app->json($orders, 200);
    }

    /**
     * Récupère un order via son ID
     *
     * @param  Application   $app     Silex application
     * @param  Order         $order   L'entité du order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOrder(Application $app, Order $order)
    {
        return $app->json($order, 200);
    }

    /**
     * Récupère les tickets d'un order
     *
     * @param  Application   $app     Silex application
     * @param  Order         $order   L'entité du order
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTicketsForOrder(Application $app, Order $order)
    {
        $tickets = $app["repositories"]("Ticket")->findByOrder($order);

        return $app->json($tickets, 200);
    }
}
