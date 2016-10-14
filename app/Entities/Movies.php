<?php

namespace CinemaHD\Entities;

use Doctrine\ORM\EntityManager;

/**
 * @Entity(repositoryClass="CinemaHD\Repositories\MoviesRepository")
 * @Table(
 *     name="movies",
 *     indexes={
 *
 *     }
 * )
 * @HasLifecycleCallbacks
 */
class ReenContractsToTerms implements \JsonSerializable
{
    /**
     * @Id
     * @JoinColumn(name="movie_id", referencedColumnName="id")
     */
    protected $movie_id;

    /**
     * @Id
     * @Column(type="integer", name="reen_student_id", length=11)
     */
    protected $reen_student_id;

    /**
     * @Id
     * @Column(type="integer", name="reen_learning_term_id", length=11)
     */
    protected $reen_learning_term_id;

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
            "reen_student_id"       => $this->getReenStudentId(),
            "reen_learning_term_id" => $this->getReenLearningTermId()
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
    public function getReenContractId()
    {
        return $this->movie_id;
    }

    /**
     * Gets the value of reen_student_id.
     *
     * @return integer
     */
    public function getReenStudentId()
    {
        return $this->reen_student_id;
    }

    /**
     * Gets the value of reen_learning_term_id.
     *
     * @return integer
     */
    public function getReenLearningTermId()
    {
        return $this->reen_learning_term_id;
    }

// ------ Setters ------

    /**
     * Sets the value of reen_contract.
     *
     * @param AbstractContract $reen_contract the reen contract
     *
     * @return self
     */
    public function setReenContract(AbstractContract $reen_contract)
    {
        $this->reen_contract = $reen_contract;

        return $this;
    }

    /**
     * Sets the value of reen_student_id.
     *
     * @param integer $reen_student_id the reen student id
     *
     * @return self
     */
    public function setReenStudentId($reen_student_id)
    {
        $this->reen_student_id = $reen_student_id;

        return $this;
    }

    /**
     * Sets the value of reen_learning_term_id.
     *
     * @param integer $reen_learning_term_id the reen learning term id
     *
     * @return self
     */
    public function setReenLearningTermId($reen_learning_term_id)
    {
        $this->reen_learning_term_id = $reen_learning_term_id;

        return $this;
    }
}
