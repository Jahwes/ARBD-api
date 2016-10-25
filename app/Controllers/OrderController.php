<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Spectator;
use CinemaHD\Entities\Ticket;
use CinemaHD\Entities\Order;
use CinemaHD\Entities\Price;
use CinemaHD\Entities\User;

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

        $controllers->post('/orders', [$this, 'createOrderAndTickets']);

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

    /**
     * creation des orders
     *
     * @param  Application   $app     Silex application
     * @param  Request       $req     Silex request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createOrderAndTickets(Application $app, Request $req)
    {
        $datas = $req->getContent();
        $datas = json_decode($datas);

        $app["orm.em"]->beginTransaction();
        try {
            $user    = self::findOrCreateUser($app, $datas->Acheteur);
            $order   = self::createOrder($app, $user);
            self::createTickets($app, $order, $datas->Ticket, $datas->Film);

            $app['orm.em']->flush();
            $app["orm.em"]->commit();

        } catch (\Exception $exception) {
            $app["orm.em"]->rollBack();
            return $app->abort(400, $exception->getMessage());
        }

        $app['orm.em']->refresh($order);

        return $app->json($order, 200);
    }

    /**
     * persist l'entité User
     *
     * @param  Application   $app     Silex application
     * @param  array         $buyer   l'acheteur
     *
     * @return User
     */
    private function findOrCreateUser(Application $app, $buyer)
    {
        $user = $app["repositories"]("User")->findOneBy(["email" => $buyer->Email]);

        if (null === $user) {
            $user = new User;

            $user->setLastname($buyer->Nom);
            $user->setFirstname($buyer->Prenom);
            $user->setDateOfBirth($buyer->Age);
            $user->setTitle($buyer->Civilite);
            $user->setEmail($buyer->Email);

            $app['orm.em']->persist($user);
        }

        return $user;
    }

    /**
     * persist l'entité Order
     *
     * @param  Application   $app     Silex application
     * @param  User          $user    User entity
     *
     * @return Order
     */
    private function createOrder(Application $app, $user)
    {
        $order = new Order;

        $order->setUser($user);

        $app['orm.em']->persist($order);

        return $order;
    }

    /**
     * persist l'entité Spectator
     *
     * @param  Application   $app     Silex application
     * @param  array         $spec   l'acheteur
     *
     * @return Spectator
     */
    private function createSpectator(Application $app, $spec)
    {
        $spectator = $app["repositories"]("Spectator")->findOneBy([
            "lastname"  => $spec->Nom,
            "firstname" => $spec->Prenom,
            "title"     => $spec->Civilite,
            "age"       => $spec->Age
        ]);

        if (null === $spectator) {
            $spectator = new Spectator;

            $spectator->setLastname($spec->Nom);
            $spectator->setFirstname($spec->Prenom);
            $spectator->setTitle($spec->Civilite);
            $spectator->setAge($spec->Age);

            $app['orm.em']->persist($spectator);
        }

        return $spectator;
    }

    /**
     * persist l'entité Order
     *
     * @param  Application   $app       Silex application
     * @param  Order         $order     la commande
     * @param  array         $tickets   les tickets acheté
     * @param  array         $movie     le film
     *
     * @return User
     */
    private function createTickets(Application $app, Order $order, $tickets, $film)
    {
        // $movie   = $app["repositories"]("Movie")->findOneBy(["title" => $movie->Titre]);
        $showing = $app["repositories"]("Showing")->findOneById(1);

        foreach ($tickets as $ticket) {
            $newTicket = new Ticket;
            $spectator = self::createSpectator($app, $ticket->Spectateur);
            $price     = $app["repositories"]("Price")->findOneBy(["type" => $ticket->Tarif]);

            $newTicket->setPrice($price);
            $newTicket->setShowing($showing);
            $newTicket->setSpectator($spectator);
            $newTicket->setOrder($order);

            $app['orm.em']->persist($newTicket);
        }
    }
}
