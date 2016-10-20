<?php

namespace CinemaHD\Utils\Doctrine;

trait CreatedAt
{
    /**
     * @Column(type="datetime", name="created_at")
     */
    private $created_at;

    /**
     * Getter
     */
    public function getCreatedAt($format = null)
    {
        switch (true) {
            case is_string($this->created_at):
            case is_object($this->created_at) && get_class($this->created_at) !== 'DateTime':
                throw new \Exception("created_at is not a datetime", 400);
            case $this->created_at === null:
            case $format === null:
                return $this->created_at;
            default:
                return $this->created_at->format($format);
        }
    }

    /**
     * @PrePersist
     */
    public function setCreatedAtBeforePersist()
    {
        $this->created_at = new \DateTime(date('Y-m-d H:i:s'));
    }
}
