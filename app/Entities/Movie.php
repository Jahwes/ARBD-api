<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

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
    use AutoIncrementId;

    /**
     * @Column(type="string", name="title", length=70, nullable=true)
     */
    protected $title;

    /**
     * @Column(type="integer", name="duration", nullable=true)
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
            "id"       => $this->getId(),
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
