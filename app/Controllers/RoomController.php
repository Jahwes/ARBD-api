<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Room;

class RoomController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/rooms', [$this, 'getRooms']);

        $controllers->get('/rooms/{room}', [$this, 'getRoom'])
            ->assert("room", "\d+")
            ->convert("room", $app["findOneOr404"]('Room', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les Rooms
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRooms(Application $app)
    {
        $rooms = $app["repositories"]("Room")->findAll();

        return $app->json($rooms, 200);
    }

    /**
     * Récupère une room via son ID
     *
     * @param  Application   $app     Silex application
     * @param  Room          $room    L'entité de la room
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRoom(Application $app, Room $room)
    {
        return $app->json($room, 200);
    }
}
