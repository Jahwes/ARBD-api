<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Type;

/**
* Listener pour une class Type
*/
class TypeIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Type $type, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($type);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Type $type, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($type);
    }

    private function index(Type $type)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("type", $type);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
