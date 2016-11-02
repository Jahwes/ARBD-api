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

    /**
     * @Column(type="boolean", name="current", options={"default"=0})
     */
    protected $current;

    public function toArray()
    {
        return [
            "id"      => $this->getId(),
            "type"    => $this->getType(),
            "value"   => $this->getValue(),
            "current" => $this->getCurrent()
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

    /**
     * Gets the value of current
     *
     * @return boolean
     */
    public function getCurrent()
    {
        return $this->current;
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

    /**
     * Sets the value of current
     *
     * @param boolean $current
     *
     * @return self
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    // ---------- ES ------------
    public function putDocument($type)
    {
        if (false === in_array($type, $this->app["elasticsearch.cinemahd.types"])) {
            throw new \Exception("Cannot put document on unconfigured type {$type} in index cinemahd");
        }

        $index_params = [
            "index" => $this->app["elasticsearch.cinemahd.index"],
            "type"  => $type,
            "id"    => $this->getId(),
            "body"  => $this->toIndex()
        ];

        return $this->app["elasticsearch.cinemahd"]->index($index_params);
    }
}
