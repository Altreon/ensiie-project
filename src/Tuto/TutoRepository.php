<?php
namespace Tuto;
class TutoRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * TutoRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT * FROM "tuto"')->fetchAll(\PDO::FETCH_OBJ);
        $tutos = [];
        foreach ($rows as $row) {
            $tuto = new Tuto();
            $tuto
                ->setId($row->id_tuto)
                ->setTitre($row->titre)
                ->setTexte($row->texte)
                ->setPdf($row->pdf);

            $tutos[] = $tuto;
        }

        return $tutos;
    }
    
    public function getTuto($id)
    {
        $row = $this->connection->query('SELECT titre, texte, pdf
                                         FROM "tuto"
                                         WHERE id_tuto = '.$id)->fetchAll(\PDO::FETCH_OBJ);
        if(count($row) == 0){
            return NULL;
        }
        $row = $row[0];
        $tuto = new Tuto();
        $tuto
        ->setId($id)
        ->setTitre($row->titre)
        ->setTexte($row->texte)
        ->setPdf($row->pdf);
        
        return $tuto;
    }
    
    public function setTuto($id, $titre, $texte, $pdf)
    {
        $sql = "UPDATE tuto
                SET titre = ?, texte = ?, pdf = ?
                WHERE id_tuto = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($titre, $texte, $pdf, $id));
        return $status;
    }
    
    public function deleteTuto($id)
    {
        $sql = "DELETE FROM tuto
                WHERE id_tuto = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id));
        return $status;
    }
    
    public function createTuto($titre, $texte, $pdf)
    {        
        $sql = "INSERT INTO tuto
                (titre, texte, pdf) VALUES (?, ?, ?);";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($titre, $texte, $pdf));
        return $status;
    }
}
