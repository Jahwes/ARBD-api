<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CinemaHD\Utils\Silex\ValidatorUtils;

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

        $controllers->post("/prices", [$this, 'createPrice']);

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
     * Créé un price
     *
     * @param  Application   $app         Silex application
     * @param  Request       $req         Requête
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createPrice(Application $app, Request $req)
    {
        $datas = $req->request->all();

        $errors = ValidatorUtils::validateEntity($app, Price::getConstraints(), $datas);
        if (count($errors) > 0) {
            return $app->json($errors, 400);
        }

        $price = new Price();
        $price->setProperties($datas);
        $price->setCurrent(true);

        $current_prices = $app["repositories"]("Price")->findBy([
            "type"    => $datas["type"],
            "current" => true
        ]);

        foreach ($current_prices as $current_price) {
            $current_price->setCurrent(false);
            $app["orm.em"]->persist($current_price);
        }

        $app["orm.em"]->persist($price);
        $app["orm.em"]->flush();

        return $app->json($price, 201);
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
