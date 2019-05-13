<?php
namespace Miseajour;

use Jeu\Jeu;

class MiseajourRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * MiseajourRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT *
                                          FROM "miseajour" NATURAL JOIN "jeux"
                                          ORDER BY date DESC')->fetchAll(\PDO::FETCH_OBJ);
        $miseajours = [];
        foreach ($rows as $row) {
            $jeu = new Jeu();
            $jeu
            ->setId($row->id_jeu)
            ->setTitre($row->titre)
            ->setGit($row->git)
            ->setTelechargement($row->telechargement);
            
            $miseajour = new Miseajour();
            $miseajour
                ->setId($row->id_maj)
                ->setJeu($jeu)
                ->setTexte($row->texte)
                ->setDate(new \DateTimeImmutable($row->date));

            $miseajours[] = $miseajour;
        }

        return $miseajours;
    }
    
    public function fetchAllFromJeu($id_jeu)
    {
        $rows = $this->connection->query('SELECT *
                                          FROM "miseajour" NATURAL JOIN "jeux"
                                          WHERE jeux.id_jeu = '.$id_jeu.'
                                          ORDER BY date DESC')->fetchAll(\PDO::FETCH_OBJ);
        $miseajours = [];
        foreach ($rows as $row) {
            $jeu = new Jeu();
            $jeu
            ->setId($id_jeu)
            ->setTitre($row->titre)
            ->setGit($row->git)
            ->setTelechargement($row->telechargement);
            
            $miseajour = new Miseajour();
            $miseajour
            ->setId($row->id_maj)
            ->setJeu($jeu)
            ->setTexte($row->texte)
            ->setDate(new \DateTimeImmutable($row->date));
            
            $miseajours[] = $miseajour;
        }
        
        return $miseajours;
    }
    
    public function getMiseajour($id)
    {
        $row = $this->connection->query('SELECT texte, date, id_jeu, titre, git, telechargement
                                         FROM "miseajour" NATURAL JOIN "jeux"
                                         WHERE id_maj = '.$id)->fetchAll(\PDO::FETCH_OBJ);

        
        if(count($row) == 0){
            return NULL;
        }
        $row = $row[0];
        
        $jeu = new Jeu();
        $jeu
        ->setId($row->id_jeu)
        ->setTitre($row->titre)
        ->setGit($row->git)
        ->setTelechargement($row->telechargement);
        
        $miseajour = new Miseajour();
        $miseajour
        ->setId($id)
        ->setJeu($jeu)
        ->setTexte($row->texte)
        ->setDate(new \DateTimeImmutable($row->date));
        
        return $miseajour;
                
    }
    
    public function setMiseajour($id, $texte, $date)
    {
        $sql = "UPDATE miseajour
                SET texte = ?, date = ?
                WHERE id_maj = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($texte, $date, $id));
        return $status;
    }
    
    public function deleteMiseajour($id)
    {
        $sql = "DELETE FROM miseajour
                WHERE id_maj = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id));
        return $status;
    }
    
    public function createMiseajour($id_jeu, $texte, $date)
    {
        $sql = "INSERT INTO miseajour
                (id_jeu, texte, date) VALUES (?, ?, ?);";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id_jeu, $texte, $date));
        return $status;
    }
}
