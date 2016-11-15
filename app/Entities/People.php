<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;
use Symfony\Component\Validator\Constraints as Assert;
use CinemaHD\Utils\Silex\ValidatorUtils;
use CinemaHD\Utils\SetPropertiesTrait;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\PeopleRepository")
 * @Table(name="People")
 * @HasLifecycleCallbacks
 */
class People implements \JsonSerializable
{
    use AutoIncrementId;
    use SetPropertiesTrait;

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
            "date_of_birth" => $this->getDateOfBirth('Y-m-d'),
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

    public static function getConstraints()
    {
        $constraints = [
            new Assert\Collection([
                'fields' => [
                    "lastname" => array_merge(
                        ValidatorUtils::notBlank(),
                        ValidatorUtils::typeIs('string'),
                        ValidatorUtils::maxLength(50)
                    ),
                    "firstname" => array_merge(
                        ValidatorUtils::notBlank(),
                        ValidatorUtils::typeIs('string'),
                        ValidatorUtils::maxLength(50)
                    ),
                    "date_of_birth" => array_merge(
                        ValidatorUtils::notBlank(),
                        ValidatorUtils::isDate()
                    ),
                    "nationality" => array_merge(
                        ValidatorUtils::notBlank(),
                        ValidatorUtils::typeIs('string'),
                        ValidatorUtils::maxLength(50)
                    )
                ],
                'allowExtraFields'   => false,
                'allowMissingFields' => false
            ])
        ];

        return $constraints;
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
    public function getDateOfBirth($format = null)
    {
        switch (true) {
            case is_string($this->date_of_birth):
            case is_object($this->date_of_birth) && 'DateTime' !== get_class($this->date_of_birth):
                throw new \Exception("date_of_birth is not a datetime", 400);
            case null === $this->date_of_birth:
            case null === $format:
                return $this->date_of_birth;
            default:
                return $this->date_of_birth->format($format);
        }
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
        $this->date_of_birth = new \DateTime(date($birth_date));

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
}
