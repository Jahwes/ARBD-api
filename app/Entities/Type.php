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
}
