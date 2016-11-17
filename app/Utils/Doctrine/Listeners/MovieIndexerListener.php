<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Movie;

/**
* Listener pour une class Movie
*/
class MovieIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Movie $movie, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($movie);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Movie $movie, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($movie);
    }

    private function index(Movie $movie)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("movie", $movie);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
