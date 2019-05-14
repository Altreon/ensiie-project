<?php
namespace Article;

use Membre\Membre;

class ArticleRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * ArticleRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT id_article, titre, texte, date, compte_rendu, id_membre, nom, prenom, surnom, promo, role
                                          FROM "article" NATURAL JOIN "membre"')->fetchAll(\PDO::FETCH_OBJ);
        $articles = [];
        foreach ($rows as $row) {
            $article = new Article();
            $auteur = new Membre();
            $auteur
            ->setId($row->id_membre)
            ->setNom($row->nom)
            ->setPrenom($row->prenom)
            ->setSurnom($row->surnom)
            ->setPromo($row->promo)
            ->setRole($row->role);
            $article
            ->setId($row->id_article)
            ->setTitre($row->titre)
            ->setTexte($row->texte)
            ->setAuteur($auteur)
            ->setDate(new \DateTimeImmutable($row->date))
            ->setCr($row->compte_rendu);
            
            $articles[] = $article;
        }
        
        return $articles;
    }
	
	public function fetchCompteRendu()
    {
        $rows = $this->connection->query('SELECT id_article, titre, texte, date, compte_rendu, id_membre, nom, prenom, surnom, promo, role
                                          FROM "article" NATURAL JOIN "membre" 
										  WHERE compte_rendu IS true
										  ORDER BY date DESC')->fetchAll(\PDO::FETCH_OBJ);
        $articles = [];
        foreach ($rows as $row) {
            $article = new Article();
            $auteur = new Membre();
            $auteur
            ->setId($row->id_membre)
            ->setNom($row->nom)
            ->setPrenom($row->prenom)
            ->setSurnom($row->surnom)
            ->setPromo($row->promo)
            ->setRole($row->role);
            $article
            ->setId($row->id_article)
            ->setTitre($row->titre)
            ->setTexte($row->texte)
            ->setAuteur($auteur)
            ->setDate(new \DateTimeImmutable($row->date))
            ->setCr($row->compte_rendu);
            
            $articles[] = $article;
        }
        
        return $articles;
    }

	public function fetchOther()
    {
        $rows = $this->connection->query('SELECT id_article, titre, texte, date, compte_rendu, id_membre, nom, prenom, surnom, promo, role
                                          FROM "article" NATURAL JOIN "membre" 
										  WHERE LOWER(titre) NOT LIKE \'%compte%rendu%\'
										  ORDER BY date DESC
										  LIMIT 10')->fetchAll(\PDO::FETCH_OBJ);
        $articles = [];
        foreach ($rows as $row) {
            $article = new Article();
            $auteur = new Membre();
            $auteur
            ->setId($row->id_membre)
            ->setNom($row->nom)
            ->setPrenom($row->prenom)
            ->setSurnom($row->surnom)
            ->setPromo($row->promo)
            ->setRole($row->role);
            $article
            ->setId($row->id_article)
            ->setTitre($row->titre)
            ->setTexte($row->texte)
            ->setAuteur($auteur)
            ->setDate(new \DateTimeImmutable($row->date))
            ->setCr($row->compte_rendu);
            
            $articles[] = $article;
        }
        
        return $articles;
    }

    public function fetchWithoutTexte()
    {
        $rows = $this->connection->query('SELECT id_article, titre, date, compte_rendu, id_membre, nom, prenom, surnom, promo, role
                                          FROM "article" NATURAL JOIN "membre"
                                          ORDER BY date DESC')->fetchAll(\PDO::FETCH_OBJ);
        $articles = [];
        foreach ($rows as $row) {
            $article = new Article();
            $auteur = new Membre();
            $auteur
                ->setId($row->id_membre)
                ->setNom($row->nom)
                ->setPrenom($row->prenom)
                ->setSurnom($row->surnom)
                ->setPromo($row->promo)
                ->setRole($row->role);
            $article
                ->setId($row->id_article)
                ->setTitre($row->titre)
                ->setAuteur($auteur)
                ->setDate(new \DateTimeImmutable($row->date))
                ->setCr($row->compte_rendu);
            
            $articles[] = $article;
        }
        
        return $articles;
    }
    
    public function getArticle($id)
    {
        $row = $this->connection->query('SELECT id_article, titre, texte, date, compte_rendu, id_membre, nom, prenom, surnom, promo, role
                                         FROM "article" NATURAL JOIN "membre"
                                         WHERE id_article = '.$id)->fetchAll(\PDO::FETCH_OBJ);
        if(count($row) == 0){
            return NULL;
        }
        $row = $row[0];
        $article = new Article();
        $auteur = new Membre();
        $auteur
            ->setId($row->id_membre)
            ->setNom($row->nom)
            ->setPrenom($row->prenom)
            ->setSurnom($row->surnom)
            ->setPromo($row->promo)
            ->setRole($row->role);
        $article
            ->setId($row->id_article)
            ->setTitre($row->titre)
            ->setTexte($row->texte)
            ->setAuteur($auteur)
            ->setDate(new \DateTimeImmutable($row->date))
            ->setCr($row->compte_rendu);
        
        return $article;
    }
    
    public function setArticle($id, $titre, $texte, $auteur, $date, $cr)
    {
        $sql = "UPDATE article
                SET titre = ?, texte = ?, id_membre = ?, date = ?, compte_rendu = ?
                WHERE id_article = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($titre, $texte, $auteur, $date, $cr, $id));
        return $status;
    }
    
    public function deleteArticle($id)
    {
        $sql = "DELETE FROM article
                WHERE id_article = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id));
        return $status;
    }
    
    public function createArticle($titre, $texte, $auteur, $date, $cr)
    {
        $sql = "INSERT INTO article
                (titre, texte, id_membre, date, compte_rendu) VALUES (?, ?, ?, ?, ?);";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($titre, $texte, $auteur, $date, $cr));
        return $status;
    }
    
    public function getIdArticle( $titre )
    {
        $row = $this->connection->query('SELECT id_article FROM article WHERE titre = \''.$titre.'\' ')->fetchAll(\PDO::FETCH_OBJ);
        if(count($row) == 0){
            return NULL;
        }
        return $row[0]->id_article;
    }
    
    public function deleteAllMedia($id){
        $rows = $this->connection->query('SELECT lien
                                          FROM media
                                          WHERE id_article = '.$id)->fetchAll(\PDO::FETCH_OBJ);
        foreach ($rows as $row) {
            if (file_exists($row->lien)) {
                unlink($row->lien);
            }
        }
        
        $sql = "DELETE FROM media
                WHERE id_article = ?";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id));
        return $status;
    }
    
    public function addMedia($id, $lien){
        $sql = "INSERT INTO media
                (id_article, lien) VALUES (?, ?);";
        $req = $this->connection->prepare($sql);
        $status = $req->execute(array($id, $lien));
        return $status;
    }
    
    public function getMedias( $id )
    {
        $rows = $this->connection->query('SELECT lien
                                          FROM media
                                          WHERE id_article = '.$id)->fetchAll(\PDO::FETCH_OBJ);
		$liens = [];
        foreach ($rows as $row) {
            $liens[] = $row->lien;
        }
        
        return $liens;
	}
	
	public function getMediasFromArticle( $id )
	{
		$res = $this->connection->query('SELECT * FROM media WHERE id_article = '.$id)->fetchAll(\PDO::FETCH_OBJ);
		return $res;
	}
}
