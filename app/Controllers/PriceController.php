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

        $controllers->get('/prices', [$this, 'getPrices']);

        $controllers->get('/prices/current', [$this, 'getCurrentPrices']);

        return $controllers;
    }


    /**
     * Récupère tous les prices
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPrices(Application $app)
    {
        $prices = $app["repositories"]("Price")->findAll();

        return $app->json($prices, 200);
    }

    /**
     * Récupère les prix en cours
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getCurrentPrices(Application $app)
    {
        $current_prices = $app["repositories"]("Price")->findBy([
            "current" => true
        ]);

        return $app->json($current_prices, 200);
    }
}
