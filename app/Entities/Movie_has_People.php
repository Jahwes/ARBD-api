<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MoviesHasPeopleRepository")
 * @Table(
 *     name="Movie_has_People",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class MovieHasPeople implements \JsonSerializable
{
    /**
     * @Id
     * @JoinColumn(name="movie_id", referencedColumnName="id", nullable=false)
     */
    protected $movie_id;

    /**
     * @Column(type="integer", name="type_id", nullable=false)
     */
    protected $people_id;

    public function toArray()
    {
        return [
            "movie_id" => $this->getMovieId(),
            "type_id"  => $this->getTypeId()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of movie_id.
     *
     * @return integer
     */
    public function getMovieId()
    {
        return $this->movie_id;
    }

    /**
     * Gets the value of people_id.
     *
     * @return integer
     */
    public function getPeopleId()
    {
        return $this->people_id;
    }

// ------ Setters ------

    /**
     * Sets the value of movie_id.
     *
     * @param interger $movie_id the movie id
     *
     * @return self
     */
    public function setMovieId($movie_id)
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    /**
     * Sets the value of people_id.
     *
     * @param interger $people_id the people_id
     *
     * @return self
     */
    public function setPeopleId($people_id)
    {
        $this->people_id = $people_id;

        return $this;
    }
}
