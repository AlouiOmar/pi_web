<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez entrer votre nom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="le nom doit avoir au moins 3 caractères.",
     *     maxMessage="le nom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    protected $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez entrer votre prénom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="le prénom doit avoir au moins 3 caractères.",
     *     maxMessage="le prénom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=30, nullable=false)
     */
    private $mail;

    /**
     * @var int
     * @Assert\NotBlank(message="Veuillez entrer votre numéro de téléphone.", groups={"Registration", "Profile"})
     * @Assert\Range(
     *     min=18,
     *     max=100,
     *     minMessage="Vous devez avoir au moins 18 ans.",
     *     maxMessage="Vous êtes trop vieux.",
     *     groups={"Registration", "Profile"}
     * )
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var int
     * @Assert\NotBlank(message="Veuillez entrer votre numéro de téléphone.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=8,
     *     max=8,
     *     minMessage="le numéro de téléphone doit contenir 8 chiffres.",
     *     maxMessage="le numéro de téléphone doit contenir 8 chiffres.",
     *     groups={"Registration", "Profile"}
     * )
     * @ORM\Column(name="telephone", type="integer", nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="passwor", type="string", length=255, nullable=true)
     */
    private $passwor;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getPasswor()
    {
        return $this->passwor;
    }

    /**
     * @param string $passwor
     */
    public function setPasswor($passwor)
    {
        $this->passwor = $passwor;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param int $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return 'uploads/user/'.$this->photo;
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



}
