<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\User;

class UserController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/users', [$this, 'getUsers']);

        $controllers->get('/users/{user}', [$this, 'getUser'])
            ->assert("user", "\d+")
            ->convert("user", $app["findOneOr404"]('User', 'id'));

        $controllers->get('/users/{user}/orders', [$this, 'getOrdersForUser'])
            ->assert("user", "\d+")
            ->convert("user", $app["findOneOr404"]('User', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les users
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUsers(Application $app)
    {
        $users = $app["repositories"]("User")->findAll();

        return $app->json($users, 200);
    }

    /**
     * Récupère un user via son ID
     *
     * @param  Application   $app     Silex application
     * @param  User          $user    L'entité du user
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUser(Application $app, User $user)
    {
        return $app->json($user, 200);
    }

    /**
     * Récupère les orders d'un user
     *
     * @param  Application   $app     Silex application
     * @param  User          $user    L'entité du user
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOrdersForUser(Application $app, User $user)
    {
        $orders = $app["repositories"]("Order")->findByUser($user);

        return $app->json($orders, 200);
    }
}
