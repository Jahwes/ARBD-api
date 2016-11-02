<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Entities\People;
use CinemaHD\Entities\Movie;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MovieHasPeopleRepository")
 * @Table(
 *     name="Movie_has_People",
 *     indexes={
 *          @Index(name="People_id", columns={"People_id"}),
 *          @Index(name="Movie_id",  columns={"Movie_id"})
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class MovieHasPeople implements \JsonSerializable
{
    /**
     * @Id
     * @ManyToOne(targetEntity="Movie", fetch="EAGER")
     * @JoinColumn(name="Movie_id", referencedColumnName="id")
     */
    protected $movie;

    /**
     * @Id
     * @ManyToOne(targetEntity="People", fetch="EAGER")
     * @JoinColumn(name="People_id", referencedColumnName="id")
     */
    protected $people;

    /**
     * @Column(type="string",
     *      name="role",
     *      columnDefinition="ENUM('producteur','réalisateur','actrice','acteur') DEFAULT NULL"),
     *      nullable=true
     * )
     */
    protected $role;

    /**
     * @Column(type="string",
     *      name="significance",
     *      columnDefinition="ENUM('principal', 'secondaire') DEFAULT NULL"),
     *      nullable=true
     * )
     */
    protected $significance;

    public function toArray()
    {
        return [
            "movie"        => $this->getMovie(),
            "type"         => $this->getType(),
            "role"         => $this->getRole(),
            "significance" => $this->getSignificance()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of movie.
     *
     * @return Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * Gets the value of people.
     *
     * @return People
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Gets the value of role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Gets the value of significance
     *
     * @return string
     */
    public function getSignificance()
    {
        return $this->significance;
    }

// ------ Setters ------

    /**
     * Sets the value of movie.
     *
     * @param Movie $movie the movie
     *
     * @return self
     */
    public function setMovie(Movie $movie)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Sets the value of people.
     *
     * @param People $people the people
     *
     * @return self
     */
    public function setPeople(People $people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Sets the value of role.
     *
     * @param string $role the role
     *
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Sets the value of significance.
     *
     * @param string $significance the significance
     *
     * @return self
     */
    public function setSignificance($significance)
    {
        $this->significance = $significance;

        return $this;
    }
}
