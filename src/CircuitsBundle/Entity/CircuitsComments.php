<?php

namespace CircuitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CircuitsComments
 *
 * @ORM\Table(name="circuits_comments")
 * @ORM\Entity(repositoryClass="CircuitsBundle\Repository\CircuitsCommentsRepository")
 */
class CircuitsComments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Content;


    /**
     * @ORM\ManyToOne(targetEntity="CircuitsBundle\Entity\Circuit", inversedBy="comments")
     * @ORM\JoinColumn(name="CircuitId", referencedColumnName="id")
     */
    private $CircuitId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param mixed $UserId
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * @param mixed $Content
     */
    public function setContent($Content)
    {
        $this->Content = $Content;
    }




    /**
     * @return mixed
     */
    public function getCircuitId()
    {
        return $this->CircuitId;
    }

    /**
     * @param mixed $CircuitId
     */
    public function setCircuitId($CircuitId)
    {
        $this->CircuitId = $CircuitId;
    }




    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $UserId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }




}

