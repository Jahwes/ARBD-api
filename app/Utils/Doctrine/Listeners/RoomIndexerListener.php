<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Room;

/**
* Listener pour une class Room
*/
class RoomIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Room $room, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($room);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Room $room, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($room);
    }

    private function index(Room $room)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("room", $room);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
