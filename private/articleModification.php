<head>
	<link rel="stylesheet" href="../CSS/style.css">
	<script rel="text/javascript" src="../JS/ajoutMedia.js"></script>
</head>

<body>

<?php
$id_page="admin";
require '../src/Article/Article.php';
require '../src/Article/ArticleRepository.php';
require '../src/Membre/Membre.php';
require '../src/Membre/MembreRepository.php';
require( "../inc/inc.default.php" );
require( "../inc/inc.nav.php" );
entete( "Accueil" ,$id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

$articleRepository = new \Article\ArticleRepository($connection);


if(!isset($_GET['id'])){ //Si aucun article selectionné, renvoie vers la page de d'administration des articles
    header("location: article.php");
}

$article = $articleRepository->getArticle($_GET['id']);

if($article == NULL){ //Si article introuvable, renvoie vers la page de d'administration des articles
    echo '<h4>Erreur: l\'article n°'.$_GET['id'].' est introuvable!</h4>';
    echo '<h4>Redirection vers la liste des articles...</h4>';
    header( "refresh:3;url=article.php" );

}else if($_SESSION['role'] != 'a' && $article->getAuteur()->getId() != $_SESSION['id']){ //Si pas administrateur, renvoie vers d'administration
		
	echo '<h4>Erreur: Vous n\'avez pas la permission de modifier cette article car vous n\'en êtes pas l\'auteur</h4>';
	echo '<h4>Redirection vers la page d\'administration...</h4>';
	header( "refresh:3;url=admin.php" );
}else if(isset($_POST['modification'])){ //Si article est modfifié, modification de la bdd puis renvoie vers la page de d'administration des articles
    if(!isset($_POST['auteur'])){
        $_POST['auteur'] = $_SESSION['id'];
    }
	$idArticle = htmlspecialchars_decode( $_GET['id'] );
	$titre     = htmlspecialchars_decode( $_POST['titre'] );
	$texte     = htmlspecialchars_decode( $_POST['texte'] );
	$auteur    = htmlspecialchars_decode( $_POST['auteur'] );
	$date      = htmlspecialchars_decode( $_POST['date'] );
    
	/*$i = 1;
	echo "patate";
	while( isset($_FILES['media'.$i]) && $i < 5 )
	{
		//$lien = htmlspecialchars_decode( $_FILES['media'.$i] );
		echo var_dump($_FILES['media'.$i]);
		echo var_dump($_POST['media'.$i]);
		$i = $i + 1;
	}*/
    
    if (isset($_POST['cr'])){
        $cr = $_POST['cr'];
    }else{
        $cr = 0;
    }
    
    $status = $articleRepository->setArticle( $idArticle, $idArticle, $texte, $auteur, $date, $cr);
    
    if($status){
        echo '<h4>L\'article n°'.$_GET['id'].' a bien été modifié</h4>';
    }else{
        echo '<h4>Erreur: la modification de l\'article n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des articles...</h4>';
    header( "refresh:3;url=article.php" );
}else if(isset($_POST['supression'])){ //Si article est supprimé, modification de la bdd puis renvoie vers la page de d'administration des articles
    
    $articleRepository->deleteAllMedia($_GET['id']);
    $status = $articleRepository->deleteArticle($_GET['id']);
    
    if($status){
        echo '<h4>L\'article n°'.$_GET['id'].' a bien été supprimé</h4>';
    }else{
        echo '<h4>Erreur: la supression de l\'article n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des articles...</h4>';
    header( "refresh:3;url=article.php" );
}else{
    
    $membreRepository = new \Membre\MembreRepository($connection);
    $membres = $membreRepository->fetchAll();

    echo '<h1>Modification de l\'article n°'.$article->getId().'</h1>';
                
    ?>
    <div class="modifContainer">
        <form action="" method="POST" enctype="multipart/form-data" id="formAjout">
        	<label>Titre : </label><input name="titre" type="text" value="<?php echo $article->getTitre() ?>" required/>
        	<br/>
        	<label>Texte : </label><textarea name="texte" rows="5" cols="40" required><?php echo $article->getTexte() ?></textarea>
        	<br/>
        	<?php if($_SESSION['role'] == 'a'){?>
            	<label>Auteur : </label>
            	<select name="auteur" required>
            		<?php
            		foreach ($membres as $membre){
            		    if($membre->getId() == $article->getAuteur()->getId()){ //Selectionne l'auteur de l'article
                            echo '<option value="'.$membre->getId().'" selected>'.$membre->getSurnom().'</option>';
            		    }else{
            		        echo '<option value="'.$membre->getId().'">'.$membre->getSurnom().'</option>';
            		    }
            		}
            		?>
				</select>
            	<br/>
            <?php } ?>
        	<label>Date de publication : </label><input name="date" type="date" value="<?php echo $article->getDate()->format('Y-m-d') ?>" required/>
			<?php
				/*$medias = $articleRepository->getMediasFromArticle($article->getId());
				$i = 1;
				foreach( $medias as $media )
				{
					echo var_dump( $media );
					echo '<div style="display: inline;">';
					echo '<input type="file" value="'.$media->lien.'" name="media'.$i.'">';
					echo '<input type="hidden" value="'.$media->id_media.'" name="idMedia'.$i.'">';
					echo '</div>';
					$i = $i + 1;
				}*/

			?>
			<input type="button" id="bAjoutMedia" onclick="ajoutMedia()" value="Ajouter une image" />
			<input type="button" id="bSuppMedia" onclick="suppMedia()" style="background-color:red" value="Supprimer la dernière image" />
        	
        	<br/><br/>
        	<?php if($article->getCr()){ ?>
        		<label>Compte-rendu : </label><input type="checkbox" name="cr" value="1" checked>
        	<?php }else{ ?>
        		<label>Compte-rendu : </label><input type="checkbox" name="cr" value="1">
        	<?php } ?>
        	<br/><br/>
        	
        	<input type="submit" name="modification" value="Envoyer"/>
        </form>
    </div>
    
    <form action="" method="POST"><input name ="supression" type="submit" class="moins" value="Supprimer l'article"/></form>
 
<?php
}
?>

</body>

<?php
	pied();
?>