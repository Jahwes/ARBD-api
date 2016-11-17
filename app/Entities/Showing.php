<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

use CinemaHD\Entities\Room;
use CinemaHD\Entities\Movie;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\ShowingRepository")
 * @EntityListeners({"CinemaHD\Utils\Doctrine\Listeners\ShowingIndexerListener"})
 * @Table(
 *     name="Showing",
 *     indexes={
 *         @Index(name="Room_id",  columns={"Room_id"}),
 *         @Index(name="Movie_id", columns={"Movie_id"})
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Showing implements \JsonSerializable
{
    use AutoIncrementId;

    /**
     * @Column(type="datetime", name="date")
     */
    protected $date;

    /**
     * @Column(type="boolean", name="3D", options={"default"=0})
     */
    protected $is_3D;

    /**
     * @ManyToOne(targetEntity="Room", fetch="EAGER")
     * @JoinColumn(name="Room_id", referencedColumnName="id")
     */
    protected $room;

    /**
     * @ManyToOne(targetEntity="Movie", fetch="EAGER")
     * @JoinColumn(name="Movie_id", referencedColumnName="id")
     */
    protected $movie;

    public function toArray()
    {
        return [
            "id"    => $this->getId(),
            "date"  => $this->getDate('Y-m-d H:i:s'),
            "is_3D" => $this->getIs3D(),
            "room"  => $this->getRoom(),
            "movie" => $this->getMovie()
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
     * Gets the value of date
     *
     * @return Date
     */
    public function getDate($format = null)
    {
        switch (true) {
            case is_string($this->date):
            case is_object($this->date) && 'DateTime' !== get_class($this->date):
                throw new \Exception("date is not a datetime", 400);
            case null === $this->date:
            case null === $format:
                return $this->date;
            default:
                return $this->date->format($format);
        }
    }

    /**
     * Gets the value of is_3D
     *
     * @return boolean
     */
    public function getIs3D()
    {
        return $this->is_3D;
    }

    /**
     * Gets the value of room
     *
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Gets the value of movie
     *
     * @return Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }

// ------ Setters ------

    /**
     * Sets the value of date
     *
     * @param date $date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Sets the value of is_3D
     *
     * @param boolean $is_3D
     *
     * @return self
     */
    public function setIs3D($is_3D)
    {
        $this->is_3D = $is_3D;

        return $this;
    }

    /**
     * Sets the value of room
     *
     * @param Room $room
     *
     * @return self
     */
    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Sets the value of movie
     *
     * @param Movie $movie
     *
     * @return self
     */
    public function setMovie($movie)
    {
        $this->movie = $movie;

        return $this;
    }
}
