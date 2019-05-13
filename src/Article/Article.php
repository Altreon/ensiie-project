<?php
namespace Article;

use Membre\Membre;

class Article
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $text;
    
    /**
     * @var Membre
     */
    private $auteur;

    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @return int
     */
    
    /**
     * @var bool
     */
    private $cr;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $Titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getTexte()
    {
        return $this->text;
    }

    /**
     * @param string $Texte
     * @return Article
     */
    public function setTexte($texte)
    {
        $this->text = $texte;
        return $this;
    }
    
    /**
     * @return Membre
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
    
    /**
     * @param Membre $auteur
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Article
     */
    public function setDate(\DateTimeInterface $date)
    {
        $this->date = $date;
        return $this;
    }


    /**
     * @return int
     * @throws \OutOfRangeException
     */
    public function joursDepuisPublication()
    {
        $now = new \DateTime();

        if ($now < $this->getDate()) {
            throw new \OutOfRangeException('Pas encore publi�');
        }

        return $now->diff($this->getDate())->y;
    }
    
    /**
     * @param bool $cr
     * @return Article
     */
    public function setCr($cr)
    {
        $this->cr = $cr;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function getCr()
    {
        return $this->cr;
    }
}

