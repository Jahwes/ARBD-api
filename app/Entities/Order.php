<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\OrderRepository")
 * @Table(
 *     name="Order",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Order implements \JsonSerializable
{
    /**
     * @Id
     * @JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order_id;

    /**
     * @Column(type="datetime", name="created_at")
     */
    protected $date;

    /**
     * @Column(type="integer", name="User_id")
     */
    protected $user_id;

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
     * Gets the value of date.
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
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

// ------ Setters ------

    /**
     * Sets the value of order_id.
     *
     * @param interger $order_id the order id
     *
     * @return self
     */
    public function setOrderId($order_id)
    {
    	$this->order_id = $order_id;

        return $this;
    }

    /**
     * Sets the value of date.
     *
     * @param interger $date the date
     *
     * @return self
     */
    public function setDate($date)
    {
    	$this->date = $date;

        return $this;
    }

    /**
     * Sets the value of user_id.
     *
     * @param interger $user_id the user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
    	$this->user_id = $user_id;

        return $this;
    }
}
