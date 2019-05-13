<head>
	<link rel="stylesheet" href="../CSS/style.css">
	<script rel="text/javascript" src="../JS/ajoutMedia.js"></script>
</head>

<body>

<?php
$id_page="admin";
require '../src/Tuto/Tuto.php';
require '../src/Tuto/TutoRepository.php';
require( "../inc/inc.default.php" );
require( "../inc/inc.nav.php" );
entete( "Accueil", $id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

$tutoRepository = new \Tuto\TutoRepository($connection);

if(isset($_POST['creation'])){ //Si l'tuto est créé, modification de la bdd puis renvoie vers la page de d'administration des tutos
    
    $status = $tutoRepository->createTuto($_POST['titre'], $_POST['texte'], $_POST['pdf']);
    
    if($status){
        echo '<h4>Le tuto a bien été créé</h4>';
    }else{
        echo '<h4>Erreur: la création du nouveau tuto a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des tutos...</h4>';
    header( "refresh:3;url=tuto.php" );
}else{

    echo '<h1>Création d\'un tutoriel</h1>';
                
    ?>
    <div class="modifContainer">
        <form action="" method="POST">
        	<label>Titre : </label><input name="titre" type="text" required/>
        	<br/>
        	<label>Texte : </label><textarea name="texte" rows="5" cols="40" required></textarea>
        	<br/>
        	<label>Lien du PDF : </label><input name="pdf" type="text" required/>
        	
        	<input type="submit" name="creation" value="Envoyer"/>
        </form>
    </div>
    
    <form action="tuto.php"><input type="submit" class="moins" value="Annuler"/></form>
 
<?php
}
?>

</body>

<?php
	pied();
?>