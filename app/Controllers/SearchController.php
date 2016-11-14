<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;

use CinemaHD\Utils\SearchUtils;

class SearchController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app["controllers_factory"];

        $controllers->get("/movies/search", [$this, "searchMovies"]);

        $controllers->get("/orders/search", [$this, "searchOrders"]);

        $controllers->get("/rooms/search", [$this, "searchRooms"]);

        $controllers->get("/users/search", [$this, "searchUsers"]);

        $controllers->get("/prices/search", [$this, "searchPrices"]);

        $controllers->get("/spectators/search", [$this, "searchSpectators"]);

        $controllers->get("/showings/search", [$this, "searchShowings"]);

        $controllers->get("/tickets/search", [$this, "searchTickets"]);

        $controllers->get("/types/search", [$this, "searchTypes"]);

        $controllers->get("/peoples/search", [$this, "searchPeoples"]);

        return $controllers;
    }

    /**
     * Effectue une recherche sur ES
     *
     * @param  Application $app         Silex application
     * @param  Request     $req         Requête HTTP
     * @param  string      $index_name
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function search(Application $app, Request $req, $index_name)
    {
        $query = $req->query->get("q", $req->query->get("query", "*"));
        $from  = $req->query->get("from", 0);
        $size  = $req->query->get("size", 10);
        $sort  = $req->query->get("sort", null);

        $sort = (1 === preg_match("#^(\+|\-)(\w+)$#", $sort, $matches)) ? [
            "sort" => [
                [ "$matches[2]" => $matches[1] === '+' ? 'asc' : 'desc']
            ]
        ] : null;


        return SearchUtils::search($app, $query, $from, $size, $index_name, $sort);
    }

    public function searchMovies(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'movie'), 200);
    }

    public function searchOrders(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'order'), 200);
    }

    public function searchRooms(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'room'), 200);
    }

    public function searchUsers(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'user'), 200);
    }

    public function searchPrices(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'price'), 200);
    }

    public function searchSpectators(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'spectator'), 200);
    }

    public function searchShowings(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'showing'), 200);
    }

    public function searchTickets(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'ticket'), 200);
    }

    public function searchTypes(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'type'), 200);
    }

    public function searchPeoples(Application $app, Request $req)
    {
        return $app->json(self::search($app, $req, 'people'), 200);
    }
}
