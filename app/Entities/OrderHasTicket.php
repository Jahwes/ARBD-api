<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\OrderHasTicketRepository")
 * @Table(
 *     name="Order_has_ticket",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class OrderHasTicket implements \JsonSerializable
{
    /**
     * @Column(name="order_id", name="Order_id")
     */
    protected $order_id;

    /**
     * @Column(type="integer", name="Order_User_id")
     */
    protected $user_id;

    /**
     * @Column(type="integer", name="Ticket_id")
     */
    protected $ticket_id;

    /**
     * @Column(type="integer", name="Ticket_Price_id")
     */
    protected $price_id;

    /**
     * @Column(type="integer", name="Ticket_Showing_id")
     */
    protected $showing_id;

    /**
     * @Column(type="integer", name="Ticket_Spectator_id")
     */
    protected $spectator_id;

    /**
     * @return string
     */
    public function __toString()
    {
        $order_id = $this->getOrderId();

        return "{$order_id}";
    }

    public function toArray()
    {
        return [
            "order_id" => $this->getOrderId(),
            "date"     => $this->getDate(),
            "user_id"  => $this->getUserId()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of order_id.
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Gets the value of user_id.
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Gets the value of ticket_id.
     *
     * @return integer
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }

    /**
     * Gets the value of price_id.
     *
     * @return integer
     */
    public function getPriceId()
    {
        return $this->price_id;
    }

    /**
     * Gets the value of showing_id.
     *
     * @return integer
     */
    public function getShowingId()
    {
        return $this->showing_id;
    }

    /**
     * Gets the value of spectator_id.
     *
     * @return integer
     */
    public function getSpectatorId()
    {
        return $this->spectator_id;
    }

// ------ Setters ------

    /**
     * Sets the value of order_id.
     *
     * @param integer $order_id the order id
     *
     * @return self
     */
    public function setOrderId($order_id)
    {
    	$this->order_id = $order_id;

        return $this;
    }

    /**
     * Sets the value of user_id.
     *
     * @param integer $user_id the user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
    	$this->user_id = $user_id;

        return $this;
    }

    /**
     * Sets the value of ticket_id.
     *
     * @param integer $ticket_id the ticket_id
     *
     * @return self
     */
    public function setTicketId($ticket_id)
    {
        $this->ticket_id = $ticket_id;

        return $this;
    }

    /**
     * Sets the value of price_id.
     *
     * @param integer $price_id the price_id
     *
     * @return self
     */
    public function setPriceId($price_id)
    {
        $this->price_id = $price_id;

        return $this;
    }

    /**
     * Sets the value of showing_id.
     *
     * @param integer $showing_id the showing_id
     *
     * @return self
     */
    public function setShowingId($showing_id)
    {
        $this->showing_id = $showing_id;

        return $this;
    }

    /**
     * Sets the value of spectator_id.
     *
     * @param integer $spectator_id the spectator_id
     *
     * @return self
     */
    public function setSpectatorId($spectator_id)
    {
        $this->spectator_id = $spectator_id;

        return $this;
    }
}
