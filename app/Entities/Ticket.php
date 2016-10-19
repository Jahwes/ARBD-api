<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

use CinemaHD\Entities\Price;
use CinemaHD\Entities\Showing;
use CinemaHD\Entities\Spectator;

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
     * @ManyToOne(targetEntity="Price", fetch="EAGER")
     * @JoinColumn(name="Price_id", referencedColumnName="id")
     */
    protected $price;

    /**
     * @ManyToOne(targetEntity="Showing", fetch="EAGER")
     * @JoinColumn(name="Showing_id", referencedColumnName="id")
     */
    protected $showing;

    /**
     * @ManyToOne(targetEntity="Spectator", fetch="EAGER")
     * @JoinColumn(name="Spectator_id", referencedColumnName="id")
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
     * Sets the value of price
     *
     * @param Price $price
     *
     * @return self
     */
    public function setPrice(Price $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Sets the value of showing
     *
     * @param Showing $showing
     *
     * @return self
     */
    public function setShowing(Showing $showing)
    {
        $this->showing = $showing;

        return $this;
    }

    /**
     * Sets the value of spectator
     *
     * @param Spectator $spectator
     *
     * @return self
     */
    public function setSpectator(Spectator $spectator)
    {
        $this->spectator = $spectator;

        return $this;
    }
}
