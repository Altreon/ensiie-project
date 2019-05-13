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

if(!isset($_GET['id_jeu'])){ //Si aucun jeu selectionné, renvoie vers la page de d'administration des jeux
    header("location: jeux.php");
}

$jeuRepository = new \Jeu\JeuRepository($connection);
$MajRepository = new \Miseajour\MiseajourRepository($connection);

$jeu = $jeuRepository->getJeu($_GET['id_jeu']);

if($jeu == NULL){ //Si le jeu introuvable, renvoie vers la page des projets
    echo '<h4>Erreur: le jeu n°'.$_GET['id_jeu'].' est introuvable!</h4>';
    echo '<h4>Redirection vers la liste des projets...</h4>';
    header( "refresh:3;url=jeux.php" );
}else if(isset($_POST['creation'])){ //Si la mise a jour est créé, modification de la bdd puis renvoie vers la page du projet
    
    $status = $MajRepository->createMiseajour($_GET['id_jeu'], $_POST['texte'], $_POST['date']);
    if($status){
        echo '<h4>La mise a jour a bien été créé</h4>';
    }else{
        echo '<h4>Erreur: la création d\'une nouvelle mise a jour a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers le projet...</h4>';
    header( "refresh:3;url=jeuModification.php?id=".$_GET['id_jeu']);
}else{

    echo '<h1>Création d\'une mise a jour</h1>';
                
    ?>
    
    <div class="modifContainer">
        <form action="" method="POST">
        	<label>Texte : </label><textarea name="texte" rows="5" cols="40" required></textarea>
        	<br/>
        	<label>Date de publication : </label><input name="date" type="date"  required/>
        	<input type="submit" name="creation" value="Envoyer"/>
        </form>
    </div>    
    
    <form action="jeuModification.php">
    	<input type="hidden" name="id" value="<?php echo $_GET['id_jeu'] ?>"/>
    	<input type="submit" class="moins" value="Annuler"/>
    </form>
 
<?php
}
?>

</body>

<?php
	pied();
?>