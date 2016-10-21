<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Entities\Movie;
use CinemaHD\Entities\Type;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MovieHasTypeRepository")
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
     * @ManyToOne(targetEntity="Movie", fetch="EAGER")
     * @JoinColumn(name="movie_id", referencedColumnName="id", nullable=false)
     */
    protected $movie;

    /**
     * @Id
     * @ManyToOne(targetEntity="Type", fetch="EAGER")
     * @JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    protected $type;

    public function toArray()
    {
        return [
            "movie" => $this->getMovie(),
            "type"  => $this->getType()
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
     * Gets the value of type.
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

// ------ Setters ------

    /**
     * Sets the value of movie.
     *
     * @param Movie $movie the movie
     *
     * @return self
     */
    public function setMovie($movie)
    {
    	$this->movie = $movie;

        return $this;
    }

    /**
     * Sets the value of type.
     *
     * @param Type $type the type
     *
     * @return self
     */
    public function setType($type)
    {
    	$this->type = $type;

        return $this;
    }
}
