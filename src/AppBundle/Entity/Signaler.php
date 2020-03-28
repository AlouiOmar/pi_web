<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signaler
 *
 * @ORM\Table(name="signaler", indexes={@ORM\Index(name="ida", columns={"ida"})})
 * @ORM\Entity(repositoryClass="Velo\AnnonceBundle\Repository\SignalerRepository")
 */
class Signaler
{
    /**
     * @var int
     *
     * @ORM\Column(name="ids", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ids;

    /**
     * @var string
     *
     * @ORM\Column(name="cause", type="string", length=255, nullable=false)
     */
    private $cause;

    /**
     * @var \AppBundle\Entity\Annonce
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Annonce")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ida", referencedColumnName="ida")
     * })
     */
    private $ida;

    /**
     * @return int
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param int $ids
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return string
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * @param string $cause
     */
    public function setCause($cause)
    {
        $this->cause = $cause;
    }

    /**
     * @return Annonce
     */
    public function getIda()
    {
        return $this->ida;
    }

    /**
     * @param Annonce $ida
     */
    public function setIda($ida)
    {
        $this->ida = $ida;
    }


}
