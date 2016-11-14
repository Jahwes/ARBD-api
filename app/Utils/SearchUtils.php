<?php

namespace CinemaHD\Utils;

use Silex\Application;

use CinemaHD\Utils\CookieUtils;

class SearchUtils
{
    /**
     * Envoie une requête à Elasticsearch pour faire de la recherche
     *
     * @param  Application $app        Silex application
     * @param  string      $query      La query de la recherche
     * @param  integer     $from       Offset de debut de la page de résultats
     * @param  integer     $size       Taille de la page de résultats
     * @param  string      $type       Nom du type sur lequel faire la recherche
     *
     * @return array                   Les resultats de la recherche Elasticsearch
     */
    public static function search(Application $app, $query, $from, $size, $type, $sort = null)
    {
        $filter_query = [
            "_source" => ['id'],
            "query"   => [
                "query_string" => [
                    "query" => $query
                ]
            ],
            "from" => $from,
            "size" => $size,
        ];

        if (null !== $sort) {
            $filter_query = array_merge($filter_query, $sort);
        }

        try {
            $response = $app["elasticsearch.cinemahd"]->search([
                "index" => $app["elasticsearch.cinemahd.index"],
                "type"  => $type,
                "body"  => $filter_query,
            ]);

            $ids = array_map(
                function ($hit) {
                    return $hit["_source"]["id"];
                },
                $response["hits"]["hits"]
            );

            $repository_names = [
                'movie'     => 'Movie',
                'order'     => 'Order',
                'room'      => 'Room',
                'user'      => 'User',
                'price'     => 'Price',
                'spectator' => 'Spectator',
                'showing'   => 'Showing',
                'ticket'    => 'Ticket',
                'type'      => 'Type',
                'people'    => 'People'
            ];

            $entities         = $app['repositories']($repository_names[$type])->findById($ids);
            $indexed_entities = array_combine(
                array_map(
                    function ($entity) {
                        return $entity->getId();
                    },
                    $entities
                ),
                $entities
            );

            $response["hits"]["hits"] = array_map(
                function ($hit) use ($indexed_entities) {
                    return $indexed_entities[$hit['_source']['id']];
                },
                $response["hits"]["hits"]
            );

            return $response["hits"];
        } catch (\Exception $exception) {
            return $app->abort(
                400,
                ('production' === $app["application_env"])? 'Search error' : $exception->getMessage()
            );
        }
    }
}
