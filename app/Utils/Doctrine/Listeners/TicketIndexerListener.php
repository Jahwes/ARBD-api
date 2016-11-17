<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Ticket;

/**
* Listener pour une class Ticket
*/
class TicketIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Ticket $ticket, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($ticket);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Ticket $ticket, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($ticket);
    }

    private function index(Ticket $ticket)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("ticket", $ticket);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
