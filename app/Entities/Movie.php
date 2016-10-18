<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MovieRepository")
 * @Table(
 *     name="movies",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Movie implements \JsonSerializable
{
    /**
     * @Id
     * @JoinColumn(name="movie_id", referencedColumnName="id")
     */
    protected $movie_id;

    /**
     * @Column(type="string", name="title", length=70)
     */
    protected $title;

    /**
     * @Column(type="integer", name="duration")
     */
    protected $duration;

    /**
     * @return string
     */
    public function __toString()
    {
        $movie_id = $this->getMovieId();

        return "{$movie_id}";
    }

    public function toArray()
    {
        return [
            "movie_id" => $this->getMovieId(),
            "title"    => $this->getTitle(),
            "duration" => $this->getDuration()
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
     * Gets the value of duration.
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Gets the value of title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Sets the value of duration.
     *
     * @param interger $duration the duration
     *
     * @return self
     */
    public function setDuration($duration)
    {
    	$this->duration = $duration;

        return $this;
    }

    /**
     * Sets the value of title.
     *
     * @param interger $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
    	$this->title = $title;

        return $this;
    }
}
