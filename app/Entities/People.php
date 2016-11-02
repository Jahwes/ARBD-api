<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\PeopleRepository")
 * @Table(name="People")
 * @HasLifecycleCallbacks
 */
class People implements \JsonSerializable
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
     * @Column(type="date", name="date_of_birth", nullable=true)
     */
    protected $date_of_birth;

    /**
     * @Column(type="string", name="nationality", length=50, nullable=true)
     */
    protected $nationality;

    public function toArray()
    {
        return [
            "id"            => $this->getId(),
            "lastname"      => $this->getLastname(),
            "firstname"     => $this->getFirstname(),
            "date_of_birth" => $this->getDateOfBirth(),
            "nationality"   => $this->getNationality()
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
     * Gets the value of date_of_birth
     *
     * @return date
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * Gets the value of nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
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
     * Gets the value of date_of_birth
     *
     * @param date
     *
     * @return self
     */
    public function setDateOfBirth($birth_date)
    {
        $this->date_of_birth = $birth_date;

        return $this;
    }

    /**
     * Gets the value of nationality
     *
     * @param string $nationality
     *
     * @return self
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    // ------- ES -----------
    public function putDocument($type)
    {
        if (false === in_array($type, $this->app["elasticsearch.cinemahd.types"])) {
            throw new \Exception("Cannot put document on unconfigured type {$type} in index cinemahd");
        }

        $index_params = [
            "index" => $this->app["elasticsearch.cinemahd.index"],
            "type"  => $type,
            "id"    => $this->getId(),
            "body"  => $this->toIndex()
        ];

        return $this->app["elasticsearch.cinemahd"]->index($index_params);
    }
}
