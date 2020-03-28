<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="idu", columns={"idu"})})
 * @ORM\Entity(repositoryClass="Velo\AnnonceBundle\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @var int
     *
     * @ORM\Column(name="ida", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ida;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var float
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @Assert\Image(
     *     minWidth = 100,
     *     maxWidth = 1400,
     *     minHeight = 100,
     *     maxHeight = 1400,
     *
     * )
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datep", type="date", nullable=false)
     */
    private $datep;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="typevelo", type="string", length=255, nullable=true)
     */
    private $typevelo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="couleur", type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="gouvernorat", type="string", length=255, nullable=false)
     */
    private $gouvernorat;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idu", referencedColumnName="id")
     * })
     */
    private $idu;

    /**
     * @return int
     */
    public function getIda()
    {
        return $this->ida;
    }

    /**
     * @param int $ida
     */
    public function setIda($ida)
    {
        $this->ida = $ida;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return 'uploads/annonce/'.$this->photo;
    }

    /**
     * @return string
     */
    public function getPhot()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * @return \DateTime
     */
    public function getDatep()
    {
        return $this->datep;
    }

    /**
     * @param \DateTime $datep
     */
    public function setDatep($datep)
    {
        $this->datep = $datep;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getTypevelo()
    {
        return $this->typevelo;
    }

    /**
     * @param null|string $typevelo
     */
    public function setTypevelo($typevelo)
    {
        $this->typevelo = $typevelo;
    }

    /**
     * @return null|string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param null|string $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    /**
     * @return string
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }

    /**
     * @param string $gouvernorat
     */
    public function setGouvernorat($gouvernorat)
    {
        $this->gouvernorat = $gouvernorat;
    }

    /**
     * @return User
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * @param User $idu
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;
    }


}
