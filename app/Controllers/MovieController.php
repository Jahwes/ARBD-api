<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Entities\Movie;

class MovieController implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        /* @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/movies', [$this, 'getMovies']);

        $controllers->get('/movies/{movie}', [$this, 'getMovie'])
            ->assert("movie", "\d+")
            ->convert("movie", $app["findOneOr404"]('Movie', 'id'));

        $controllers->get('/movies/{movie}/showings', [$this, 'getShowingsForMovie'])
            ->assert("movie", "\d+")
            ->convert("movie", $app["findOneOr404"]('Movie', 'id'));

        $controllers->get('/movies/{movie}/people', [$this, 'getPeopleForMovie'])
            ->assert("movie", "\d+")
            ->convert("movie", $app["findOneOr404"]('Movie', 'id'));

        $controllers->get('/movies/{movie}/types', [$this, 'getTypesForMovie'])
            ->assert("movie", "\d+")
            ->convert("movie", $app["findOneOr404"]('Movie', 'id'));

        return $controllers;
    }

    /**
     * Récupère tous les movies
     *
     * @param  Application   $app     Silex application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getMovies(Application $app)
    {
        $movies = $app["repositories"]("Movie")->findAll();

        return $app->json($movies, 200);
    }

    /**
     * Récupère un movie via son ID
     *
     * @param  Application   $app     Silex application
     * @param  Movie         $movie   L'entité du movie
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getMovie(Application $app, Movie $movie)
    {
        return $app->json($movie, 200);
    }

    /**
     * Récupère les showings d'un movie
     *
     * @param  Application   $app     Silex application
     * @param  Movie         $movie   L'entité du movie
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getShowingsForMovie(Application $app, Movie $movie)
    {
        $showings = $app["repositories"]("Showing")->findByMovie($movie);

        return $app->json($showings, 200);
    }

    /**
     * Récupère les people d'un movie
     *
     * @param  Application   $app     Silex application
     * @param  Movie         $movie   L'entité du movie
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getPeopleForMovie(Application $app, Movie $movie)
    {
        $movie_has_people = $app["repositories"]("MovieHasPeople")->findByMovie($movie);
        $people = array_map(
            function ($mhp) {
                return $mhp->getPeople();
            },
            $movie_has_people
        );

        return $app->json($people, 200);
    }

    /**
     * Récupère les types d'un movie
     *
     * @param  Application   $app     Silex application
     * @param  Movie         $movie   L'entité du movie
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTypesForMovie(Application $app, Movie $movie)
    {
        $movie_has_type = $app["repositories"]("MovieHasType")->findByMovie($movie);
        $types = array_map(
            function ($mht) {
                return $mht->getType();
            },
            $movie_has_type
        );

        return $app->json($types, 200);
    }
}
