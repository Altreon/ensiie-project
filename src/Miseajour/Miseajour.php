<?php
namespace Miseajour;

use Jeu\Jeu;

class Miseajour
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $jeu;
    
    /**
     * @var string
     */
    private $texte;

    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Miseajour
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Jeu
     */
    public function getJeu()
    {
        return $this->jeu;
    }

    /**
     * @param Jeu $jeu
     * @return Miseajour
     */
    public function setJeu($jeu)
    {
        $this->jeu = $jeu;
        return $this;
    }

    /**
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param string $texte
     * @return Miseajour
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
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
     * @return Miseajour
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}

