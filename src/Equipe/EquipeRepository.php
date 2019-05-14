<?php
namespace Equipe;

use Membre\Membre;
use Jeu\JeuRepository;



class EquipeRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * EquipeRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $jeuRepository = new JeuRepository($this->connection);
        
        $rows = $this->connection->query('SELECT id_jeu, id_membre, equipe.role, nom, prenom, surnom, promo, membre.role
                                          FROM "equipe" NATURAL JOIN "membre"
                                          ORDER BY id_jeu')->fetchAll(\PDO::FETCH_OBJ);
        $equipes = [];
        
        $id_jeu = -1;
        $membres = array();
        $roles = array();
        
        foreach ($rows as $row) {
            if($row->id_jeu != $id_jeu && !empty($membres)){
                $jeu = $jeuRepository->getJeu($id_jeu);
                
                $equipe = new Equipe();
                $equipe
                    ->setJeu($jeu)
                    ->setMembres($membres)
                    ->setRoles($roles);
                
                $equipes[] = $equipe;
                
                $id_jeu = $row->id_jeu;
                unset($membres);
                unset($roles);
                $membres = array();
                $roles = array();
                
            }
            
            $membre = new Membre();
            $membre
            ->setId($row->id_membre)
            ->setNom($row->nom)
            ->setPrenom($row->prenom)
            ->setSurnom($row->surnom)
            ->setPromo($row->promo)
            ->setRole($row->membre.role);
            
            $membres[] = $membre;
            $roles[membre] = $row->equipe.role;
        }

        return $equipes;
	}
	
	public function createEquipe( $idJeu, $idMembre, $role )
	{
		$sql = "INSERT INTO equipe VALUES (?, ?, ?);";
		$req = $this->connection->prepare($sql);
		$status = $req->execute(array($idJeu,$idMembre, $role) );
		return $status;
	}

	public function setEquipe( $idJeu, $idMembre, $role )
	{
		$sql = "UPDATE equipe SET equipe.role = ? WHERE id_jeu = ? AND id_membre = ?;";
		$req = $this->connection->prepare($sql);
		$status = $req->execute(array($idJeu,$idMembre, $role) );
		return $status;
	}


	public function deleteEquipe( $idJeu, $idMembre )
	{
		$sql = "DELETE FROM equipe WHERE id_jeu = ? AND id_membre= ?";
		$req = $this->connection->prepare($sql);
		$status = $req->execute(array($idJeu,$idMembre) );
		return $status;
	}
    
    public function getEquipe($idJeu)
    {
        $jeuRepository = new JeuRepository($this->connection);
        
        $rows = $this->connection->query('SELECT membre.id_membre, equipe.role as erole, nom, prenom, surnom, promo, membre.role
                                          FROM equipe JOIN membre on equipe.id_membre = membre.id_membre
                                          WHERE id_jeu = '.$idJeu)->fetchAll(\PDO::FETCH_OBJ);
        
        $jeu = $jeuRepository->getJeu($idJeu);
                
        $membres = array();
        $roles = array();
        foreach ($rows as $row) { 
            $membre = new Membre();
            $membre
            ->setId($row->id_membre)
            ->setNom($row->nom)
            ->setPrenom($row->prenom)
            ->setSurnom($row->surnom)
            ->setPromo($row->promo)
            ->setRole($row->role);
            
            $membres[] = $membre;
            $roles[$membre->getId()] = $row->erole;
        }
        
        $equipe = new Equipe();
        $equipe
        ->setJeu($jeu)
        ->setMembres($membres)
        ->setRoles($roles);
        
        return $equipe;
    }
	
	public function faitPartieEquipe($idJeu, $id_membre){
		$equipe = $this->getEquipe($idJeu);
		foreach ($equipe->getMembres() as $membre) {
			if($id_membre == $membre->getId()){
				return true;
			}
		}
		
		return false;
	}
}
