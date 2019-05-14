<?php
namespace Jeu;
class JeuRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * JeuRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT * FROM "jeux" ORDER BY titre')->fetchAll(\PDO::FETCH_OBJ);
        $jeux = [];
        foreach ($rows as $row) {
            $jeu = new Jeu();
            $jeu
                ->setId($row->id_jeu)
                ->setTitre($row->titre)
                ->setGit($row->git)
                ->setTelechargement($row->telechargement)
				->setDescription($row->description);

            $jeux[] = $jeu;
        }

        return $jeux;
    }
    
    public function getJeu($id)
    {
        $row = $this->connection->query('SELECT * FROM "jeux" WHERE id_jeu = '.$id)->fetchAll(\PDO::FETCH_OBJ);
        if(count($row) == 0){
            return NULL;
        }
        
        $row = $row[0];
        $jeu = new Jeu();
        $jeu
            ->setId($row->id_jeu)
            ->setTitre($row->titre)
            ->setGit($row->git)
            ->setTelechargement($row->telechargement)
			->setDescription($row->description);
        
        return $jeu;
    }
    
    public function setJeu($id, $titre, $git, $telechargement, $description)
    {
        $sql = "UPDATE jeux
                SET titre = ?, git = ?, telechargement = ?, description = ?
                WHERE id_jeu = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($titre, $git, $telechargement, $description, $id));
        return $status;
    }
    
    public function deleteJeu($id)
    {
        $sql = "DELETE FROM jeux
                WHERE id_jeu = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id));
        return $status;
	}
	
	public function getIdJeu( $titre )
	{
		$res = $this->connection->query('SELECT id_jeu FROM jeux WHERE titre = \''.$titre.'\' ' )->fetchAll();
		return $res[0]['id_jeu'];
	}
    
    public function createJeu($titre, $git, $telechargement, $description)
    {
        $sql = "INSERT INTO jeux
                (titre, git, telechargement,description) VALUES (?, ?, ?, ?);";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($titre, $git, $telechargement, $description));
        return $status;
    }
	
	public function deleteAllMedia($id){
        $rows = $this->connection->query('SELECT lien
                                          FROM media
                                          WHERE id_jeu = '.$id)->fetchAll(\PDO::FETCH_OBJ);
        foreach ($rows as $row) {
            if (file_exists($row->lien)) {
                unlink($row->lien);
            }
        }
        
        $sql = "DELETE FROM media
                WHERE id_jeu = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id));
        return $status;
    }
    
    public function addMedia($id, $lien){
        $sql = "INSERT INTO media
                (id_jeu, lien) VALUES (?, ?);";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id, $lien));
        return $status;
    }
    
    public function getMedias( $id )
    {
        $rows = $this->connection->query('SELECT lien
                                          FROM media
                                          WHERE id_jeu = '.$id)->fetchAll(\PDO::FETCH_OBJ);
        $liens = [];
        foreach ($rows as $row) {
            $liens[] = $row->lien;
        }
        
        return $liens;
	}
	
	public function getMediasFromJeu( $id )
	{
		$res = $this->connection->query('SELECT * FROM media WHERE id_jeu = '.$id)->fetchAll(\PDO::FETCH_OBJ);
		return $res;
	}
}
