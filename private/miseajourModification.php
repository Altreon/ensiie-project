<head>
	<link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

<?php
$id_page="admin";
require '../src/Jeu/Jeu.php';
require '../src/Jeu/JeuRepository.php';
require '../src/Miseajour/Miseajour.php';
require '../src/Miseajour/MiseajourRepository.php';
require( "../inc/inc.default.php" );
require( "../inc/inc.nav.php" );
entete( "Accueil" ,$id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

if(!isset($_GET['id'])){ //Si aucun miseajour selectionné, renvoie vers la page de d'administration des mise a jours
    header("location: jeux.php");
}

$MajRepository = new \Miseajour\MiseajourRepository($connection);
$maj = $MajRepository->getMiseajour($_GET['id']);

if($maj == NULL){ //Si la mise à jour introuvable, renvoie vers la page des projets
    echo '<h4>Erreur: la mise a jour n°'.$_GET['id'].' est introuvable!</h4>';
    echo '<h4>Redirection vers la liste des projets...</h4>';
    header( "refresh:3;url=jeux.php" );

}else if(isset($_POST['modification'])){ //Si la mise a jour est modfifié, modification de la bdd puis renvoie vers la page de modification du projet
    $status = $MajRepository->setMiseajour($_GET['id'], $_POST['texte'], $_POST['date']);
    
    if($status){
        echo '<h4>La mise a jour n°'.$_GET['id'].' a bien été modifié</h4>';
    }else{
        echo '<h4>Erreur: la modification de la mise a jour n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers le projet...</h4>';
    header( "refresh:3;url=jeuModification.php?id=".$maj->getJeu()->getId());
}else if(isset($_POST['supression'])){ //Si la mise a jour est supprimé, modification de la bdd puis renvoie vers la page de modification du projet
	$MajRepository->deleteAllMedia($_GET['id']);
	$status = $MajRepository->deleteMiseajour($_GET['id']);
    
    if($status){
        echo '<h4>La mise a jour n°'.$_GET['id'].' a bien été supprimé</h4>';
    }else{
        echo '<h4>Erreur: la supression de la mise a jour n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers le projet...</h4>';
    header( "refresh:3;url=jeuModification.php?id=".$maj->getJeu()->getId());
}else{

    echo '<h1>Modification de la mise a jour n°'.$maj->getId().'</h1>';
                
    ?>
    <div class="modifContainer">
        <form action="" method="POST">
        	<label>Texte : </label><textarea name="texte" rows="5" cols="40" required><?php echo $maj->getTexte() ?></textarea>
        	<br/>
        	<label>Date de publication : </label><input name="date" type="date" value="<?php echo $maj->getDate()->format('Y-m-d') ?>" required/>
        	<?php
				echo '<a href="../private/mediaModification.php?idMaj='.$maj->getId().'" >Modifier l\'image de mise à jour</a>';
			?>
			<input type="submit" name="modification" value="Envoyer"/>
        </form>
    </div>
    
    <form action="" method="POST"><input name ="supression" type="submit" class="moins" value="Supprimer la mise a jour"/></form>
 
<?php
}
?>

</body>

<?php
	pied();
?>