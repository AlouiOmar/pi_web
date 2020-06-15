<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", uniqueConstraints={@ORM\UniqueConstraint(name="un_tit", columns={"titre"})}, indexes={@ORM\Index(name="fx_circuit", columns={"name_C"})})
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=30, nullable=false)
     */
    private $titre;

    /**
     * @var string

     * @ORM\Column(name="date_E", type="string", nullable=false)
     */

    private $dateE;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=20, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="name_C", type="string", length=30, nullable=true)
     */
    private $nameC = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="nbplaces", type="integer",options={"default" : 1})
     */
    private $nbplaces=1;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Event
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set dateE
     *
     * @param string $dateE
     *
     * @return Event
     */
    public function setDateE($dateE)
    {
        $this->dateE = $dateE;

        return $this;
    }

    /**
     * Get dateE
     *
     * @return string
     */
    public function getDateE()
    {
        return $this->dateE;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Event
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set nameC
     *
     * @param string $nameC
     *
     * @return Event
     */
    public function setNameC($nameC)
    {
        $this->nameC = $nameC;

        return $this;
    }

    /**
     * Get nameC
     *
     * @return string
     */
    public function getNameC()
    {
        return $this->nameC;
    }

    /**
     * @return int
     */
    public function getNbplaces()
    {
        return $this->nbplaces;
    }

    /**
     * @param int $nbplaces
     */
    public function setNbplaces($nbplaces)
    {
        $this->nbplaces = $nbplaces;
    }

    /**
     * Many series have Many panier.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="eventparticiper")
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     *@ORM\JoinColumn(name="creator", referencedColumnName="id")
     */
    private $creator;

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param mixed $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }


    public function addparticipation(\AppBundle\Entity\User $user)
    {
        if (!$this->participant->contains($user)) {
            $this->participant[] = $user;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param mixed $participant
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;
    }


}
