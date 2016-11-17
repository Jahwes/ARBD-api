<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Showing;

/**
* Listener pour une class Showing
*/
class ShowingIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Showing $showing, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($showing);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Showing $showing, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($showing);
    }

    private function index(Showing $showing)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("showing", $showing);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
