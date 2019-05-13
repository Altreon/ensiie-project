<?php
namespace Membre;

class Membre
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;
    
    /**
     * @var string
     */
    private $prenom;
    
    /**
     * @var string
     */
    private $surnom;

    /**
     * @var int
     */
    private $promo;

    /**
     * @var int
     */
    private $role;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Membre
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return Membre
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
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
     * @return Membre
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSurnom()
    {
        return $this->surnom;
    }
    
    /**
     * @param string $surnom
     * @return Membre
     */
    public function setSurnom($surnom)
    {
        $this->surnom = $surnom;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getPromo()
    {
        return $this->promo;
    }
    
    /**
     * @param int $promo
     * @return Membre
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
        return $this;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return Membre
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
}

