<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Price;

/**
* Listener pour une class Price
*/
class PriceIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Price $price, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($price);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Price $price, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($price);
    }

    private function index(Price $price)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("price", $price);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
