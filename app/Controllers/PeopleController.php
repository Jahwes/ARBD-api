<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\People;

class PeopleController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/peoples', [$this, 'getPeoples']);

        $controllers->get('/peoples/{people}', [$this, 'getPeople'])
            ->assert("people", "\d+")
            ->convert("people", $app["findOneOr404"]('People', 'id'));

        $controllers->get('/peoples/{people}/movies', [$this, 'getMoviesForPeople'])
            ->assert("people", "\d+")
            ->convert("people", $app["findOneOr404"]('People', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les peoples
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPeoples(Application $app)
    {
        $peoples = $app["repositories"]("People")->findAll();

        return $app->json($peoples, 200);
    }

    /**
     * Récupère un people via son ID
     *
     * @param  Application   $app         Silex application
     * @param  People        $people      L'entité du people
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPeople(Application $app, People $people)
    {
        return $app->json($people, 200);
    }

    /**
     * Récupère les films d'un people avec son rôle
     *
     * @param  Application   $app         Silex application
     * @param  People        $people      L'entité du people
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getMoviesForPeople(Application $app, People $people)
    {
        $movie_has_people = $app["repositories"]("MovieHasPeople")->findByMovie($people);
        $movies = array_map(
            function ($mhp) {
                return [
                    "movie"        => $mhp->getMovie(),
                    "role"         => $mhp->getRole(),
                    "significance" => $mhp->getSignificance()
                ];
            },
            $movie_has_people
        );

        return $app->json($movies);
    }
}
