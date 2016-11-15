<?php

namespace CinemaHD\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use CinemaHD\Utils\Silex\ValidatorUtils;

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

        $controllers->post("/peoples", [$this, 'createPeople']);

        $controllers->put('/peoples/{people}', [$this, 'updatePeople'])
            ->assert("people", "\d+")
            ->convert("people", $app["findOneOr404"]('People', 'id'));

        $controllers->get('/peoples/{people}/movies', [$this, 'getMoviesForPeople'])
            ->assert("people", "\d+")
            ->convert("people", $app["findOneOr404"]('People', 'id'));

        $controllers->get('/peoples/{people}/score', [$this, 'getScoreForPeople'])
            ->assert("people", "\d+")
            ->convert("people", $app["findOneOr404"]('People', 'id'));

        $controllers->get('/peoples/top', [$this, 'getTopForType']);

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
     * Créé un people
     *
     * @param  Application   $app         Silex application
     * @param  Request       $req         Requête
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createPeople(Application $app, Request $req)
    {
        $datas = $req->request->all();

        $errors = ValidatorUtils::validateEntity($app, People::getConstraints(), $datas);
        if (count($errors) > 0) {
            return $app->json($errors, 400);
        }

        $people = new People();
        $people->setProperties($datas);

        $app["orm.em"]->persist($people);
        $app["orm.em"]->flush();

        return $app->json($people, 201);
    }

    /**
     * Update un people
     *
     * @param  Application   $app         Silex application
     * @param  Request       $req         Requête
     * @param  People        $people      L'entité du people
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updatePeople(Application $app, Request $req, People $people)
    {
        $datas = $req->request->all();

        $errors = ValidatorUtils::validateEntity($app, People::getConstraints(), $datas);
        if (count($errors) > 0) {
            return $app->json($errors, 400);
        }

        $people->setProperties($datas);

        $app["orm.em"]->persist($people);
        $app["orm.em"]->flush();

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

        return $app->json($movies, 200);
    }

    /**
     * Calcule le score d'un acteur
     *
     * @param  Application   $app         Silex application
     * @param  People        $people      L'entité du people
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getScoreForPeople(Application $app, People $people)
    {
        $score = $app["repositories"]("People")->getScoreForPeople($people);

        return $app->json($score, 200);
    }

    /**
     * Fait un classement des acteurs, actrices ou les deux
     *
     * @param  Application   $app         Silex application
     * @param  Request       $req
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTopForType(Application $app, Request $req)
    {
        // $type doit être both, acteur ou actrice
        $type = $req->query->get("type", "both");

        $peoples = $app["repositories"]("People")->getPeoplesByRole($type);

        $scores = [];
        foreach ($peoples as $people) {
            $ln  = $people->getLastname();
            $fn  = $people->getFirstname();
            $key = "{$ln} {$fn}";

            $scores[$key] = $app["repositories"]("People")->getScoreForPeople($people);
        }

        arsort($scores);

        return $app->json($scores, 200);
    }
}
