<?php
namespace Equipe;

use Jeu\Jeu;
use Membre\Membre;

class Equipe
{
    /**
     * @var Jeu
     */
    private $jeu;

    /**
     * @var Membre[]
     */
    private $membres;
    
    /**
     * @var int=>string[]
     */
    private $roles;

    /**
     * @return Jeu
     */
    public function getJeu()
    {
        return $this->jeu;
    }

    /**
     * @param Jeu $jeu
     * @return Equipe
     */
    public function setJeu($jeu)
    {
        $this->jeu = $jeu;
        return $this;
    }

    /**
     * @return Membre[]
     */
    public function getMembres()
    {
        return $this->membres;
    }

    /**
     * @param string[] $membres
     * @return Equipe
     */
    public function setMembres($membres)
    {
        $this->membres = $membres;
        return $this;
    }

    /**
     * @return int=>string[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param int=>string[] $roles
     * @return Equipe
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }
    
    /**
     * @param int $membre
     * @return string
     */
    public function getRole($membre)
    {
        if(isset($this->roles[$membre])){
            return $this->roles[$membre];
        }else{
            return "";
        }
    }
    
}