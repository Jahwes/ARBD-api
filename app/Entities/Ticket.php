<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use Utils\Doctrine\AutoIncrementId;

use Entities\Price;
use Entities\Showing;
use Entities\Spectator;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\TicketRepository")
 * @Table(
 *     name="Ticket",
 *     indexes={
 *         @Index(name="Price_id",     columns={"Price_id"}),
 *         @Index(name="Showing_id",   columns={"Showing_id"}),
 *         @Index(name="Spectator_id", columns={"Spectator_id"})
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Ticket implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @Column(type="string", name="name", length=45, nullable=true)
     */
    protected $price;

    /**
     * @Column(type="string", name="name", length=45, nullable=true)
     */
    protected $showing;

    /**
     * @Column(type="string", name="name", length=45, nullable=true)
     */
    protected $spectator;

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "price"     => $this->getPrice(),
            "showing"   => $this->getShowing(),
            "spectator" => $this->getSpectator()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of price
     *
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Gets the value of showing
     *
     * @return Showing
     */
    public function getShowing()
    {
        return $this->showing;
    }

    /**
     * Gets the value of spectator
     *
     * @return Spectator
     */
    public function getSpectator()
    {
        return $this->spectator;
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
}
