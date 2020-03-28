<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="id_U", columns={"id_U"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_P", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idP;

    /**
     * @var int
     *
     * @ORM\Column(name="id_U", type="integer", nullable=false)
     */
    private $idU;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_P", type="string", length=30, nullable=false)
     */
    private $nomP;

    /**
     * @var string
     *
     * @ORM\Column(name="type_P", type="string", length=20, nullable=false)
     */
    private $typeP;

    /**
     * @var string
     *
     * @ORM\Column(name="marque_P", type="string", length=20, nullable=false)
     */
    private $marqueP;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categorie_P", type="string", length=20, nullable=true)
     */
    private $categorieP;

    /**
     * @var string|null
     *
     * @ORM\Column(name="couleur_P", type="string", length=20, nullable=true)
     */
    private $couleurP;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_P", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixP;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo_P", type="string", length=500, nullable=true)
     */
    private $photoP;


}
