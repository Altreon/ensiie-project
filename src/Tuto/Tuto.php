<?php
namespace Tuto;

class Tuto
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
    private $texte;
    
    /**
     * @var string
     */
    private $pdf;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Tuto
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
     * @param string $titre
     * @return Tuto
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
        return $this->texte;
    }

    /**
     * @param string $texte
     * @return Tuto
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }
    
    /**
     * @param string $pdf
     * @return Tuto
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
        return $this;
    }
}

