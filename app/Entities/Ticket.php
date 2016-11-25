<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

use CinemaHD\Entities\Price;
use CinemaHD\Entities\Showing;
use CinemaHD\Entities\Spectator;
use CinemaHD\Entities\Order;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\TicketRepository")
 * @EntityListeners({"CinemaHD\Utils\Doctrine\Listeners\TicketIndexerListener"})
 * @Table(
 *     name="Ticket",
 *     indexes={
 *         @Index(name="Price_id",     columns={"Price_id"}),
 *         @Index(name="Showing_id",   columns={"Showing_id"}),
 *         @Index(name="Spectator_id", columns={"Spectator_id"}),
 *         @Index(name="Order_id",     columns={"Order_id"})
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Ticket implements \JsonSerializable
{
    use AutoIncrementId;

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

    /**
     * @ManyToOne(targetEntity="Order", fetch="EAGER")
     * @JoinColumn(name="Order_id", referencedColumnName="id")
     */
    protected $order;

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "price"     => $this->getPrice(),
            "showing"   => $this->getShowing(),
            "spectator" => $this->getSpectator(),
            "order"     => $this->getOrder()
        ];
    }

    public function toIndex()
    {
        $price     = $this->getPrice();
        $showing   = $this->getShowing();
        $spectator = $this->getSpectator();
        $order     = $this->getOrder();

        return [
            "price_type"       => $price->getType(),
            "price_value"      => $price->getValue(),
            "price_current"    => $price->getCurrent(),
            "showing_date"     => $showing->getDate('Y-m-d H:i:s'),
            "is_3D"            => $showing->getIs3D(),
            "movie_title"      => $showing->getMovie()->getTitle(),
            "spectator_age"    => $spectator->getAge(),
            "spectator_title"  => $spectator->getTitle(),
            "order_created_at" => $order->getCreatedAt('Y-m-d'),
            "user_title"       => $order->getUser()->getTitle(),
            "user_email"       => $order->getUser()->getEmail()
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

    /**
     * Gets the value of order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
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

    /**
     * Sets the value of order
     *
     * @param Order $order
     *
     * @return self
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }
}
