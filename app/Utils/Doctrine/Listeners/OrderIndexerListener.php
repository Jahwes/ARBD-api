<?php

namespace CinemaHD\Utils\Doctrine\Listeners;

use Silex\Application;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

use CinemaHD\Entities\Order;

/**
* Listener pour une class Order
*/
class OrderIndexerListener
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /** @PostPersist */
    public function postPersistHandler(Order $order, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($order);
    }

    /** @PostUpdate */
    public function postUpdatedHandler(Order $order, LifecycleEventArgs $event)
    {
        $event = $event;
        $this->index($order);
    }

    private function index(Order $order)
    {
        try {
            $this->app["elasticsearch.cinemahd.indexer"]->putDocument("order", $order);
        } catch (\Exception $exception) {
            return;
            // try catch pour gérer le ElasticSearchLock qui renvoie une erreur dans le cas des tests behat
        }
    }
}
