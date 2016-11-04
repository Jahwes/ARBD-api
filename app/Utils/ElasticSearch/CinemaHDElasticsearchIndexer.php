<?php

namespace CinemaHD\Utils\Elasticsearch;

use Doctrine\ORM\Tools\Pagination\Paginator;

use CinemaHD\Utils\Elasticsearch\AbstractIndexer;

use Silex\Application;

/**
*
*/
class CinemaHDElasticsearchIndexer extends AbstractIndexer
{
    public function __construct(Application $app)
    {
        parent::__construct($app, "cinemahd");
    }

    private function indexOneEntity($es_type, $entity_name, $id)
    {
        $entity = $this->app["repositories"]($entity_name)->findOneBy(["id" => $id]);

        if (null === $entity) {
            throw new \Exception("Cannot index {$entity_name} {$id} because it does not exist");
        }
        self::putDocument($es_type, $entity);
    }

    protected function indexOneMovie($id)
    {
        self::indexOneEntity("movie", "CinemaHD\Movie", $id);
    }

    protected function indexOneOrder($id)
    {
        self::indexOneEntity("order", "CinemaHD\Order", $id);
    }

    protected function indexOnePeople($id)
    {
        self::indexOneEntity("people", "CinemaHD\People", $id);
    }

    protected function indexOnePrice($id)
    {
        self::indexOneEntity("price", "CinemaHD\Price", $id);
    }

    protected function indexOneRoom($id)
    {
        self::indexOneEntity("room", "CinemaHD\Room", $id);
    }

    protected function indexOneShowing($id)
    {
        self::indexOneEntity("showing", "CinemaHD\Showing", $id);
    }

    protected function indexOneSpectator($id)
    {
        self::indexOneEntity("spectator", "CinemaHD\Spectator", $id);
    }

    protected function indexOneTicket($id)
    {
        self::indexOneEntity("ticket", "CinemaHD\Ticket", $id);
    }

    protected function indexOneType($id)
    {
        self::indexOneEntity("type", "CinemaHD\Type", $id);
    }

    protected function indexOneUser($id)
    {
        self::indexOneEntity("user", "CinemaHD\User", $id);
    }

    private function index($dql, $type)
    {
        $min_id       = 0;
        $first_result = 0;
        $chunk_size   = 500;

        echo "Indexing {$type} .";
        do {
            $query = $this->app["orm.em"]->createQuery($dql);
            $query
                ->setFirstResult($first_result)
                ->setMaxResults($chunk_size)
                ->setParameter("min_id", $min_id);
            $paginator = new Paginator($query);
            $count     = 0;

            foreach ($paginator as $entity) {
                $count++;
                $result = $this->putDocument($type, $entity);
                if (!isset($result) || true !== $result["created"]) {
                    print_r($result);
                }
                unset($entity);
                echo '.';
            }

            unset($paginator);
            $this->app["orm.em"]->clear();
            $first_result += $chunk_size;
        } while ($count == $chunk_size);
        echo "\n";
    }

    protected function indexMovie()
    {
        $dql = "SELECT movie
            FROM     CinemaHD\Entities\Movie movie
            WHERE    movie.id > :min_id
            ORDER BY movie.id ASC";

        self::index($dql, "movie");
    }

    protected function indexOrder()
    {
        $dql = "SELECT o
            FROM     CinemaHD\Entities\Order o
            WHERE    o.id > :min_id
            ORDER BY o.id ASC";

        self::index($dql, "order");
    }

    protected function indexPeople()
    {
        $dql = "SELECT people
            FROM     CinemaHD\Entities\People people
            WHERE    people.id > :min_id
            ORDER BY people.id ASC";

        self::index($dql, "people");
    }

    protected function indexPrice()
    {
        $dql = "SELECT price
            FROM     CinemaHD\Entities\Price price
            WHERE    price.id > :min_id
            ORDER BY price.id ASC";

        self::index($dql, "price");
    }

    protected function indexRoom()
    {
        $dql = "SELECT room
            FROM     CinemaHD\Entities\Room room
            WHERE    room.id > :min_id
            ORDER BY room.id ASC";

        self::index($dql, "room");
    }

    protected function indexShowing()
    {
        $dql = "SELECT showing
            FROM     CinemaHD\Entities\Showing showing
            WHERE    showing.id > :min_id
            ORDER BY showing.id ASC";

        self::index($dql, "showing");
    }

    protected function indexSpectator()
    {
        $dql = "SELECT spectator
            FROM     CinemaHD\Entities\Spectator spectator
            WHERE    spectator.id > :min_id
            ORDER BY spectator.id ASC";

        self::index($dql, "spectator");
    }

    protected function indexTicket()
    {
        $dql = "SELECT ticket
            FROM     CinemaHD\Entities\Ticket ticket
            WHERE    ticket.id > :min_id
            ORDER BY ticket.id ASC";

        self::index($dql, "ticket");
    }

    protected function indexType()
    {
        $dql = "SELECT type
            FROM     CinemaHD\Entities\Type type
            WHERE    type.id > :min_id
            ORDER BY type.id ASC";

        self::index($dql, "type");
    }

    protected function indexUser()
    {
        $dql = "SELECT user
            FROM     CinemaHD\Entities\User user
            WHERE    user.id > :min_id
            ORDER BY user.id ASC";

        self::index($dql, "user");
    }

    public function putDocument($type, $entity)
    {
        if (false === in_array($type, $this->app["elasticsearch.cinemahd.types"])) {
            throw new \Exception("Cannot put document on unconfigured type {$type} in index cinemahd");
        }

        $index_params = [
            "index" => $this->app["elasticsearch.cinemahd.index"],
            "type"  => $type,
            "id"    => $entity->getId(),
            "body"  => $entity->toIndex()
        ];

        return $this->app["elasticsearch.cinemahd"]->index($index_params);
    }

    public function removeDocument($type, $document_id = null)
    {
        if (false === in_array($type, $this->app["elasticsearch.cinemahd.types"])) {
            throw new \Exception("Cannot delete document on unconfigured type {$type} in index cinemahd");
        }

        if (null === $document_id) {
            throw new \Exception("No id provided");
        }

        $index_params = [
            "index" => $this->app["elasticsearch.cinemahd.index"],
            "type"  => $type,
            "id"    => $document_id,
        ];

        return $this->app["elasticsearch.cinemahd"]->delete($index_params);
    }
}
