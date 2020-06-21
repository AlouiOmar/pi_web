<?php

namespace CircuitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Time;

/**
 * Circuit
 *
 * @ORM\Table(name="circuit")
 * @ORM\Entity(repositoryClass="CircuitsBundle\Repository\CircuitRepository")
 */
class Circuit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="CircuitsBundle\Entity\Station")
     * @ORM\JoinColumn(name="depart",referencedColumnName="id")
     */
    private $depart;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="CircuitsBundle\Entity\Station")
     * @ORM\JoinColumn(name="pause",referencedColumnName="id")
     */
    private $pause;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="CircuitsBundle\Entity\Station")
     * @ORM\JoinColumn(name="end",referencedColumnName="id")
     */
    private $end;

    /**
     * @var float
     *
     * @ORM\Column(name="distance", type="float")
     */
    private $distance;






    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=20)
     */
    private $difficulty;

    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Circuit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return int
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @param int $depart
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;
    }



    /**
     * Set difficulty
     *
     * @param string $difficulty
     *
     * @return Circuit
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return int
     */
    public function getPause()
    {
        return $this->pause;
    }

    /**
     * @param int $pause
     */
    public function setPause($pause)
    {
        $this->pause = $pause;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param int $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * Get difficulty
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }



    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
}



