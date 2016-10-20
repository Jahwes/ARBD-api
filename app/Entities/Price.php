<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

use CinemaHD\Utils\Doctrine\AutoIncrementId;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\PriceRepository")
 * @Table(name="Price")
 * @HasLifecycleCallbacks
 */
class Price implements \JsonSerializable
{
    use AutoIncrementId;

    /**
     * @Column(type="string", name="type_name", nullable=true)
     */
    protected $type;

    /**
     * @Column(type="float", name="value", nullable=true)
     */
    protected $value;

    public function toArray()
    {
        return [
            "id"    => $this->getId(),
            "type"  => $this->getType(),
            "value" => $this->getValue()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

// ------ Getters ------

    /**
     * Gets the value of type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets the value of value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }
// ------ Setters ------

    /**
     * Sets the value of type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Sets the value of value
     *
     * @param integer $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
