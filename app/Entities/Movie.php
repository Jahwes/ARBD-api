<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints as Assert;
use CinemaHD\Utils\Silex\ValidatorUtils;
use CinemaHD\Utils\SetPropertiesTrait;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MovieRepository")
 * @EntityListeners({"CinemaHD\Utils\Doctrine\Listeners\MovieIndexerListener"})
 * @Table(
 *     name="Movie",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class Movie implements \JsonSerializable
{
    use AutoIncrementId;
    use SetPropertiesTrait;

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
                    "title" => array_merge(
                        ValidatorUtils::notBlank(),
                        ValidatorUtils::typeIs('string'),
                        ValidatorUtils::maxLength(70)
                    ),
                    "duration" => array_merge(
                        ValidatorUtils::notBlank(),
                        ValidatorUtils::typeIs('integer')
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
