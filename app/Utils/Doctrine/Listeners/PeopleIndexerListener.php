<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\People;

/**
* Listener pour une class People
*/
class PeopleIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(People $people, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($people);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(People $people, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($people);
    }

    private function index(People $people)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("people", $people);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
