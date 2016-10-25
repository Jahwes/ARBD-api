<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\SpectatorRepository")
 * @Table(name="Spectator")
 * @HasLifecycleCallbacks
 */
class Spectator implements \JsonSerializable
{
    use AutoIncrementId;

    /**
     * @Column(type="string", name="lastname", length=50, nullable=true)
     */
    protected $lastname;

    /**
     * @Column(type="string", name="firstname", length=50, nullable=true)
     */
    protected $firstname;

    /**
     * @Column(type="integer", name="age", nullable=true)
     */
    protected $age;

    /**
     * @Column(type="string", name="title", columnDefinition="ENUM('Monsieur','Madame','Mademoiselle') DEFAULT NULL"), nullable=true
     */
    protected $title;

    public function toArray()
    {
        return [
            "id"        => $this->getId(),
            "lastname"  => $this->getLastname(),
            "firstname" => $this->getFirstname(),
            "age"       => $this->getAge(),
            "title"     => $this->getTitle()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Gets the value of firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Gets the value of age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Gets the value of title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

// ------ Setters ------

    /**
     * Sets the value of lastname
     *
     * @param string $lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Sets the value of firstname
     *
     * @param string $firstname
     *
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Gets the value of age
     *
     * @param date
     *
     * @return self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Gets the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
