<head>
	<link rel="stylesheet" href="../CSS/style.css">
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


if(!isset($_GET['id'])){ //Si aucun tuto selectionné, renvoie vers la page de d'administration des tutos
    header("location: tuto.php");
}

$tuto = $tutoRepository->getTuto($_GET['id']);

if($tuto == NULL){ //Si tuto introuvable, renvoie vers la page de d'administration des tutos
    echo '<h4>Erreur: le tuto n°'.$_GET['id'].' est introuvable!</h4>';
    echo '<h4>Redirection vers la liste des tutos...</h4>';
    header( "refresh:3;url=tuto.php" );

}else if(isset($_POST['modification'])){ //Si tuto est modfifié, modification de la bdd puis renvoie vers la page de d'administration des tutos
    
    $status = $tutoRepository->setTuto($_GET['id'], $_POST['titre'], $_POST['texte'], $_POST['pdf']);
    
    if($status){
        echo '<h4>Le tuto n°'.$_GET['id'].' a bien été modifié</h4>';
    }else{
        echo '<h4>Erreur: la modification du tuto n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des tutos...</h4>';
    header( "refresh:3;url=tuto.php" );
}else if(isset($_POST['supression'])){ //Si tuto est supprimé, modification de la bdd puis renvoie vers la page de d'administration des tutos
    
    $status = $tutoRepository->deleteTuto($_GET['id']);
    
    if($status){
        echo '<h4>Le tuto n°'.$_GET['id'].' a bien été supprimé</h4>';
    }else{
        echo '<h4>Erreur: la supression du tuto n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des tutos...</h4>';
    header( "refresh:3;url=tuto.php" );
}else{

    echo '<h1>Modification du tutoriel n°'.$tuto->getId().'</h1>';
                
    ?>
    <div class="modifContainer">
        <form action="" method="POST">
        	<label>Titre : </label><input name="titre" type="text" required value="<?php echo $tuto->getTitre() ?>"/>
        	<br/>
        	<label>Texte : </label><textarea name="texte" rows="5" cols="40" required><?php echo $tuto->getTexte() ?></textarea>
        	<br/>
        	<label>Lien du PDF : </label><input name="pdf" type="text" value="<?php echo $tuto->getPdf() ?>" required/>
        	
        	<input type="submit" name="modification" value="Envoyer"/>
        </form>
    </div>
    
    <form action="" method="POST"><input name ="supression" type="submit" class="moins" value="Supprimer l'tuto"/></form>
 
<?php
}
?>

</body>

<?php
	pied();
?>