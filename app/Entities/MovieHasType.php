<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MoviesHasTypeRepository")
 * @Table(
 *     name="Movie_has_Type",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class MovieHasType implements \JsonSerializable
{
    /**
     * @Id
     * @JoinColumn(name="movie_id", referencedColumnName="id", nullable=false)
     */
    protected $movie_id;

    /**
     * @Id
     * @Column(type="integer", name="type_id", nullable=false)
     */
    protected $type_id;

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
     * Gets the value of type_id.
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
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
     * Sets the value of type_id.
     *
     * @param interger $type_id the type_id
     *
     * @return self
     */
    public function setTypeId($type_id)
    {
    	$this->type_id = $type_id;

        return $this;
    }
}
