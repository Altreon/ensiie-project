<head>
	<link rel="stylesheet" href="../CSS/style.css">
	<script rel="text/javascript" src="../JS/ajoutMedia.js"></script>
</head>

<body>

<?php
$id_page="admin";
require '../src/Jeu/Jeu.php';
require '../src/Jeu/JeuRepository.php';
require '../src/Equipe/Equipe.php';
require '../src/Equipe/EquipeRepository.php';
require( "../inc/inc.default.php" );
require( "../inc/inc.nav.php" );
entete( "Accueil" ,$id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

$jeuRepository = new \Jeu\JeuRepository($connection);
$equipeRepository = new \Equipe\EquipeRepository($connection);

if(isset($_POST['creation'])){ //Si le jeu est créé, modification de la bdd puis renvoie vers la page de d'administration des jeux

	$titreJeu    = htmlspecialchars_decode($_POST['titre']);
	$git         = htmlspecialchars_decode($_POST['git']);
	$lienT       = htmlspecialchars_decode($_POST['telechargement']);
	$description = htmlspecialchars_decode($_POST['description']);
 
	$status = $jeuRepository->createJeu($titreJeu, $git, $lienT, $description);

	$idJeu = $jeuRepository->getIdJeu( $titreJeu );

	$i = 1;
	while( isset($_POST['membre'.$i]) && isset($_POST['roleMembre'.$i]) )
	{
		$idMembre = htmlspecialchars_decode($_POST['membre'.$i]);
		$role     = htmlspecialchars_decode($_POST['roleMembre'.$i]);
		$equipeRepository->createEquipe( $idJeu, $idMembre, $role );
		$i = $i + 1;
	}
	
	$i = 1;
    $envoie = TRUE;
    while( isset($_FILES['media'.$i] )) {
        $lien = "../media/";
        $lien = $lien . basename($_FILES['media'.$i]['name']);
        if(!move_uploaded_file($_FILES['media'.$i]['tmp_name'], $lien)) {
            echo '<h1>'.var_dump($lien).'</h1>';
            $envoie = FALSE;
            break;
        }else{
            $jeuRepository->addMedia($idJeu, $lien);
        }
        $i = $i + 1;
    }

	if($status && $envoie){
		echo '<h4>Le projet a bien été créé</h4>';
	}else{
		echo '<h4>Erreur: la création du nouveau projet a échoué!</h4>';
	}

	echo '<h4>Redirection vers la liste des projets...</h4>';
	header( "refresh:3;url=jeux.php" );
}else{

    echo '<h1>Création d\'un projet</h1>';
                
    ?>
    <div class="modifContainer">
        <form id="formAjout" id="formAjoutProjet" action="" method="POST" onsubmit="return verficationEnvoie()" enctype="multipart/form-data">
        	<label>Titre : </label><input name="titre" type="text" required/>
        	<br/>
			<label>Description : </label><textarea name="description" rows="5" cols="40" required></textarea>
			<br/>
        	<label>Lien du git : </label><textarea name="git" rows="5" cols="40" required></textarea>
        	<br/>
			<label>Lien de téléchargement : </label><textarea name="telechargement" rows="5" cols="40" required></textarea>
			<input type="button" id="bAjoutMembre" onclick="ajoutMembre()" value="Ajouter un membre" />
			<input type="button" id="bSuppMembre" onclick="suppMembre()" style="background-color:red" value="Supprimer le dernier Membre" />
        	
			<input type="button" id="bAjoutMedia" onclick="ajoutMedia()" value="Ajouter une image" />
			<input type="button" id="bSuppMedia" onclick="suppMedia()" style="background-color:red" value="Supprimer la dernière image" />
        	
        	<input type="submit" id="bEnvoyer" name="creation" value="Envoyer"/>
        </form>
    </div>
    
    <form action="jeux.php"><input type="submit" class="moins" value="Annuler"/></form>
 
<?php
}
?>

</body>

<?php
	pied();
?>