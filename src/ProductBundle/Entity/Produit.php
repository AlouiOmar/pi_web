<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="nom_P", columns={"nom_P"})})
 * @ORM\Entity
 */
class Produit
{

    /**
     * @return int
     */
    public function getIdP()
    {
        return $this->idP;
    }

    /**
     * @param int $idP
     */
    public function setIdP($idP)
    {
        $this->idP = $idP;
    }


    /**
     * @return string
     */
    public function getNomP()
    {
        return $this->nomP;
    }

    /**
     * @param string $nomP
     */
    public function setNomP($nomP)
    {
        $this->nomP = $nomP;
    }

    /**
     * @return string
     */
    public function getTypeP()
    {
        return $this->typeP;
    }

    /**
     * @param string $typeP
     */
    public function setTypeP($typeP)
    {
        $this->typeP = $typeP;
    }

    /**
     * @return string
     */
    public function getMarqueP()
    {
        return $this->marqueP;
    }

    /**
     * @param string $marqueP
     */
    public function setMarqueP($marqueP)
    {
        $this->marqueP = $marqueP;
    }

    /**
     * @return string
     */
    public function getCategorieP()
    {
        return $this->categorieP;
    }

    /**
     * @param string $categorieP
     */
    public function setCategorieP($categorieP)
    {
        $this->categorieP = $categorieP;
    }

    /**
     * @return string
     */
    public function getCouleurP()
    {
        return $this->couleurP;
    }

    /**
     * @param string $couleurP
     */
    public function setCouleurP($couleurP)
    {
        $this->couleurP = $couleurP;
    }

    /**
     * @return float
     */
    public function getPrixP()
    {
        return $this->prixP;
    }

    /**
     * @param float $prixP
     */
    public function setPrixP($prixP)
    {
        $this->prixP = $prixP;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getPhotoP()
    {
        return $this->photoP;
    }

    /**
     * @param string $photoP
     */
    public function setPhotoP($photoP)
    {
        $this->photoP = $photoP;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id_P", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idP;


    public function __toString()
    {
return $this->nomP;    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom_P", type="string", length=100, nullable=true)
     */
    private $nomP;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ProductBundle\Entity\Typeproduit")
     * @ORM\JoinColumn(name="typeP",referencedColumnName="id_TP")
     */
    private $typeP;

    /**
     * @var string
     *
     * @ORM\Column(name="marque_P", type="string", length=20, nullable=true)
     */
    private $marqueP;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_P", type="string", length=20, nullable=true)
     */
    private $categorieP ;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur_P", type="string", length=20, nullable=true)
     */
    private $couleurP;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_P", type="float",nullable=true)
     */
    private $prixP;
    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer", nullable=true)
     */
    private $tel;

    /**
     * @return float
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param float $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="photo_P", type="string", length=500, nullable=true)
     */
    private $photoP ;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
     private $id ;
}

