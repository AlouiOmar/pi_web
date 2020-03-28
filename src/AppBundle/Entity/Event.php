<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", uniqueConstraints={@ORM\UniqueConstraint(name="un_tit", columns={"titre"})}, indexes={@ORM\Index(name="name_c", columns={"name_C"})})
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_E", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idE;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=30, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="date_E", type="text", length=65535, nullable=false)
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
     * @var string|null
     *
     * @ORM\Column(name="name_C", type="string", length=30, nullable=true)
     */
    private $nameC;


}
