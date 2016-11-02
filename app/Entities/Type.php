<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\TypeRepository")
 * @Table(name="Type")
 * @HasLifecycleCallbacks
 */
class Type implements \JsonSerializable
{
    use AutoIncrementId;

    /**
     * @Column(type="string", name="name", length=45, nullable=true)
     */
    protected $name;

    public function toArray()
    {
        return [
            "id"   => $this->getId(),
            "name" => $this->getName()
        ];
    }

    public function toIndex()
    {
        return $this->toArray();
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

// ------ Setters ------

    /**
     * Sets the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    // ------------ ES -------------
    public function putDocument($type)
    {
        if (false === in_array($type, $this->app["elasticsearch.cinemahd.types"])) {
            throw new \Exception("Cannot put document on unconfigured type {$type} in index cinemahd");
        }

        $index_params = [
            "index" => $this->app["elasticsearch.cinemahd.index"],
            "type"  => $type,
            "id"    => $this->getId(),
            "body"  => $this->toIndex()
        ];

        return $this->app["elasticsearch.cinemahd"]->index($index_params);
    }
}
