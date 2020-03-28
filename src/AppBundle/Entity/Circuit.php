<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Circuit
 *
 * @ORM\Table(name="circuit", indexes={@ORM\Index(name="en", columns={"end"}), @ORM\Index(name="pa", columns={"pause"}), @ORM\Index(name="beg", columns={"begin"})})
 * @ORM\Entity
 */
class Circuit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="begin", type="string", length=20, nullable=false)
     */
    private $begin;

    /**
     * @var string
     *
     * @ORM\Column(name="end", type="string", length=20, nullable=false)
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="pause", type="string", length=20, nullable=false)
     */
    private $pause;

    /**
     * @var float
     *
     * @ORM\Column(name="distance", type="float", precision=10, scale=0, nullable=false)
     */
    private $distance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time", nullable=false)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=50, nullable=false)
     */
    private $difficulty;


}
