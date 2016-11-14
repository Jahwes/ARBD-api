<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\UserRepository")
 * @Table(name="User")
 * @HasLifecycleCallbacks
 */
class User implements \JsonSerializable
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
     * @Column(type="string", name="title", columnDefinition="ENUM('Monsieur','Madame','Mademoiselle') DEFAULT NULL"), nullable=true
     */
    protected $title;

    /**
     * @Column(type="string", name="email", length=45, nullable=true)
     */
    protected $email;

    public function toArray()
    {
        return [
            "id"            => $this->getId(),
            "lastname"      => $this->getLastname(),
            "firstname"     => $this->getFirstname(),
            "date_of_birth" => $this->getDateOfBirth('Y-m-d'),
            "title"         => $this->getTitle(),
            "email"         => $this->getEmail()
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
     * Gets the value of title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Gets the value of email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * @param integer
     *
     * @return self
     */
    public function setDateOfBirth($age)
    {
        if (is_int($age)) {
            $date                = date('Y');
            $birth_date          = $date - $age;
            $birth_date          = new \DateTime("{$birth_date}-01-01");
            $this->date_of_birth = $birth_date;
        }

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

    /**
     * Gets the value of email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
