<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\User;

/**
* Listener pour une class User
*/
class UserIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(User $user, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($user);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(User $user, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($user);
    }

    private function index(User $user)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("user", $user);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
