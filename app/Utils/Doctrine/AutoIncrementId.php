<?php

namespace CinemaHD\Utils\Doctrine;

trait AutoIncrementId
{
    /**
     * @Id @GeneratedValue
     * @Column(type="integer", name="id")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        throw new \Exception(__METHOD__ . " : method not implemented");
    }
}
