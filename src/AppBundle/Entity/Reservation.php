<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="reservation_l", columns={"id_L"}), @ORM\Index(name="reservation", columns={"id_U"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_R", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idR;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeb", type="date", nullable=false)
     */
    private $datedeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date", nullable=false)
     */
    private $datefin;

    /**
     * @var int
     *
     * @ORM\Column(name="id_L", type="integer", nullable=false)
     */
    private $idL;

    /**
     * @var int
     *
     * @ORM\Column(name="id_U", type="integer", nullable=false)
     */
    private $idU;


}
