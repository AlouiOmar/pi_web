<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeproduit
 *
 * @ORM\Table(name="typeproduit")
 * @ORM\Entity
 */
class Typeproduit
{

    /**
     * @var integer
     * @ORM\Column(name="id_TP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTp;

    /**
     * @return int
     */
    public function getIdTp()
    {
        return $this->idTp;
    }

    /**
     * @param int $idTp
     */
    public function setIdTp($idTp)
    {
        $this->idTp = $idTp;
    }

    /**
     * @return string
     */
    public function getLibelleTp()
    {
        return $this->libelleTp;
    }

    /**
     * @param string $libelleTp
     */
    public function setLibelleTp($libelleTp)
    {
        $this->libelleTp = $libelleTp;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_TP", type="string", length=60, nullable=false)
     */
    private $libelleTp;


}

