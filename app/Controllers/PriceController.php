<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Price;

class PriceController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/prices', [$this, 'index']);

        return $controllers;
    }

    public function index(Application $app)
    {
        $prices = $app["repositories"]("Price")->getPrices();
        var_dump($prices);die();

        return $app->json($prices, 200);
    }
}
