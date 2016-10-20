<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\RoomRepository")
 * @Table(name="Room")
 * @HasLifecycleCallbacks
 */
class Room implements \JsonSerializable
{
    use AutoIncrementId;

    /**
     * @Column(type="integer", name="nb_places")
     */
    protected $nb_places;

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "nb_places" => $this->getNbPlaces()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of nb_places
     *
     * @return integer
     */
    public function getNbPlaces()
    {
        return $this->nb_places;
    }

// ------ Setters ------

    /**
     * Sets the value of nb_places
     *
     * @param integer $nb_places
     *
     * @return self
     */
    public function setNbPlaces($nb_places)
    {
        $this->nb_places = $nb_places;

        return $this;
    }
}
