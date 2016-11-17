<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Spectator;

/**
* Listener pour une class Spectator
*/
class SpectatorIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Spectator $spectator, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($spectator);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Spectator $spectator, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($spectator);
    }

    private function index(Spectator $spectator)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("spectator", $spectator);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
