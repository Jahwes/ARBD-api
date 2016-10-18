<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\OrderRepository")
 * @Table(
 *     name="Order",
 *     indexes={
 *          @Index(name="User_id",  columns={"User_id"})
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Order implements \JsonSerializable
{
    use AutoIncrementID;

    /**
     * @Column(type="datetime", name="created_at", nullable=true)
     */
    protected $date;

    /**
     * @ManyToOne(targetEntity="User", fetch="EAGER")
     * @JoinColumn(name="User_id", referencedColumnName="id")
     */
    protected $user;

    public function toArray()
    {
        return [
            "id"   => $this->getId(),
            "date" => $this->getDate(),
            "user" => $this->getUser()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

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
     * Gets the value of user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

// ------ Setters ------

    /**
     * Sets the value of date.
     *
     * @param date $date the date
     *
     * @return self
     */
    public function setDate($date)
    {
    	$this->date = $date;

        return $this;
    }

    /**
     * Sets the value of user.
     *
     * @param User $user the user
     *
     * @return self
     */
    public function setUser(User $user)
    {
    	$this->user = $user;

        return $this;
    }
}
