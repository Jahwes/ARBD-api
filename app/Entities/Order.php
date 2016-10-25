<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;
use CinemaHD\Utils\Doctrine\CreatedAt;

use CinemaHD\Entities\User;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\OrderRepository")
 * @Table(
 *     name="`Order`",
 *     indexes={
 *          @Index(name="User_id",  columns={"User_id"})
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Order implements \JsonSerializable
{
    use AutoIncrementId;
    use CreatedAt;

    /**
     * @ManyToOne(targetEntity="User", fetch="EAGER")
     * @JoinColumn(name="User_id", referencedColumnName="id")
     */
    protected $user;

    public function toArray()
    {
        return [
            "id"         => $this->getId(),
            "created_at" => $this->getCreatedAt('Y-m-d'),
            "user"       => $this->getUser()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

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
