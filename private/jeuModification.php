<head>
	<link rel="stylesheet" href="../CSS/style.css">
	<script rel="text/javascript" src="../JS/ajoutChamp.js"></script>
</head>

<body>

<?php
$id_page="admin";
require '../src/Jeu/Jeu.php';
require '../src/Jeu/JeuRepository.php';
require '../src/Equipe/Equipe.php';
require '../src/Equipe/EquipeRepository.php';
require '../src/Membre/Membre.php';
require '../src/Membre/MembreRepository.php';
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

if(!isset($_GET['id'])){ //Si aucun jeu selectionné, renvoie vers la page de d'administration des jeux
    header("location: jeux.php");
}

$jeuRepository = new \Jeu\JeuRepository($connection);
$equipesRepository = new \Equipe\EquipeRepository($connection);
$membresRepository = new \Membre\MembreRepository($connection);

$jeu = $jeuRepository->getJeu($_GET['id']);
if($jeu == NULL){ //Si jeu introuvable, renvoie vers la page de d'administration des jeux

    echo '<h4>Erreur: le projet n°'.$_GET['id'].' est introuvable!</h4>';
    echo '<h4>Redirection vers la liste des projets...</h4>';
	header( "refresh:3;url=jeux.php" );
	
}else if($_SESSION['role'] == 'a' || $equipesRepository->faitPartieEquipe($jeu->getId(), $_SESSION['id'])){ //Si pas administrateur, renvoie vers d'administration
		
	echo '<h4>Erreur: Vous n\'avez pas la permission de modifier ce projet car vous ne faites pas partie de l\'equipe</h4>';
	echo '<h4>Redirection vers la page d\'administration...</h4>';
	header( "refresh:3;url=admin.php" );
	
}else if(isset($_POST['modification'])){ //Si jeu est modfifié, modification de la bdd puis renvoie vers la page de d'administration des jeux
	
	$idJeu       = htmlspecialchars_decode($_GET['id']);
	$titreJeu    = htmlspecialchars_decode($_POST['titre']);
	$git         = htmlspecialchars_decode($_POST['git']);
	$lienT       = htmlspecialchars_decode($_POST['telechargement']);
	$description = htmlspecialchars_decode($_POST['description']);

	$status = $jeuRepository->setJeu($idJeu, $titreJeu, $git, $lienT, $description);

	$i = 1;
	$membres = $equipesRepository->getEquipe($idJeu)->getMembres();
	while( isset($_POST['membre'.$i]) && isset($_POST['roleMembre'.$i]) )
	{
		$idMembre = htmlspecialchars_decode($_POST['membre'.$i]);
		$role     = htmlspecialchars_decode($_POST['roleMembre'.$i]);
		
		$isModify = false;
		foreach( $membres as $membre )
		{
			if( $membre->getId()==intval( $idMembre ) )
			{
				$equipesRepository->setEquipe( $_GET['id'], $idMembre, $role );
				$isModify = true;
				$k = array_search($membre,$membres);
				unset( $membres[$k] );
			}
		}
		if( $isModify == false )
		{
			$equipesRepository->createEquipe( $idJeu, $idMembre, $role );
		}
		$i = $i + 1;
	}

	foreach( $membres as $membre )
	{
		$equipesRepository->deleteEquipe( $idJeu, $idMembre );
	}
	
    if($status){
        echo '<h4>Le projet n°'.$_GET['id'].' a bien été modifié</h4>';
    }else{
        echo '<h4>Erreur: la modification du projet n°'.$_GET['id'].' a échoué!</h4>';
    }
    
	echo '<h4>Redirection vers la liste des projets...</h4>';
	
    header( "refresh:3;url=jeux.php" );
}else if(isset($_POST['supression'])){ //Si jeu est supprimé, modification de la bdd puis renvoie vers la page de d'administration des jeux
	
	$status = $jeuRepository->deleteJeu($_GET['id']);
    
    if($status){
        echo '<h4>Le projet n°'.$_GET['id'].' a bien été supprimé</h4>';
    }else{
        echo '<h4>Erreur: la supression du projet n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des projets...</h4>';
    header( "refresh:3;url=jeux.php" );
}else{
	
	$MajRepository = new \Miseajour\MiseajourRepository($connection);
    $majs = $MajRepository->fetchAllFromJeu($_GET['id']);
    
    echo '<h1>Modification du projet n°'.$jeu->getId().'</h1>';
                
    ?>
    <div class="modifContainer">
        <form action="" method="POST" id="formAjoutProjet">
        	<label>Titre : </label><input name="titre" type="text" value="<?php echo $jeu->getTitre() ?>" required/>
        	<br/>
        	<label>Description : </label><textarea name="description" rows="5" cols="40" required><?php echo $jeu->getDescription() ?></textarea>
        	<br/>
        	<label>Lien du git : </label><input name="git" type="text" value="<?php echo $jeu->getGit() ?>" required/>
			<br/>
			<label>Lien de téléchargement : </label><input name="telechargement" type="text" value="<?php echo $jeu->getTelechargement() ?>" required/>
			<?php
				$equipes = $equipesRepository->getEquipe( $jeu->getId() );
				$membres = $membresRepository->fetchAll();
				$i = 1;
				foreach( $equipes->getMembres() as $equipe )
				{
					echo '<div style="display:flex;">'."\n";
					echo '<select name="membre'.$i."\" required=\"required\" class=\"selectName\" style=\"display: inline; width: 50%;\">"."\n";
					foreach( $membres as $membre )
					{
						if( $membre->getId() == $equipe->getId())
						{
							echo '<option value="'.$membre->getId().'" selected="selected" >'.$membre->getSurnom().'</option>'."\n";
						}
						else
						{
							echo '<option value="'.$membre->getId().'">'.$membre->getSurnom().'</option>'."\n";
						}
					}
					echo "</select>\n";
					echo '<input type="text" required="" name="roleMembre'.$i.'" value="'.$equipes->getRoles()[$equipe->getId()].'" placeholder="rôle" style="display: inline; width: 50%;">';
					echo '</div>'."\n";
					$i = $i + 1;
				}
			?>
			<input type="button" id="bAjoutMembre" onclick="ajoutMembre()" value="Ajouter un membre" />
			<input type="button" id="bSuppMembre" onclick="suppMembre()" style="background-color:red" value="Supprimer le dernier Membre" />
        	<input type="submit" name="modification" value="Envoyer"/>
        </form>
    </div>
    
    <form action="" method="POST"><input name ="supression" type="submit" class="moins" value="Supprimer le projet"/></form>
    
    <br/><br/>
    
    <h4>Cliquez sur une mise à jour pour la modifier ou la supprimer</h4>

    <ul>
    	<?php 
    	foreach ($majs as $maj) {
			echo '<li><a href="miseajourModification.php?id='.$maj->getId().'">'.$maj->getDate()->format('d/m/Y').'</li>';
    	}
    	?>
    </ul>
    
    <form action="miseajourCreation.php">
    	<input type="hidden" name="id_jeu" value="<?php echo $jeu->getId() ?>"/>
    	<input type="submit" class="plus" value="Écrire une mise à jour"/>
    </form>
    
    <br/>
    <form action="admin.php"><input type="submit" class="moins" value="Revenir à l'espace d'administration"/></form>
     
<?php
}
?>


<?php
	pied();
?>