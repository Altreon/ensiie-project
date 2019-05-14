<head>
	<link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

<?php
$id_page="admin";
require '../src/Jeu/Jeu.php';
require '../src/Jeu/JeuRepository.php';
require '../src/Membre/Membre.php';
require '../src/Membre/MembreRepository.php';
require '../src/Equipe/Equipe.php';
require '../src/Equipe/EquipeRepository.php';
require( "../inc/inc.default.php" );
require( "../inc/inc.nav.php" );
entete( "jeux" ,$id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}



$jeuRepository = new \Jeu\JeuRepository($connection);
$equipeRepository = new \Equipe\EquipeRepository($connection);
$jeux = $jeuRepository->fetchAll();
?>

<h1>Administration des projets</h1>

<h3>Cliquez sur un projet pour le modifier ou le supprimer</h3>

<div style="overflow-x:auto;">
    <table>
    	<tr><th>Titre</th></tr>
    	<?php 
    	foreach ($jeux as $jeu) {
    	    if($_SESSION['role'] == 'a' || $equipeRepository->faitPartieEquipe($jeu->getId(), $_SESSION['id'])){
        	    echo 
        	    '<tr><td>
                    <a href="jeuModification.php?id='.$jeu->getId().'">'.$jeu->getTitre().'</a>
                 </td></tr>';
    	    }
    	}
    	?>
    </table>
</div>
<form action="jeuCreation.php"><input type="submit" class="plus" value="Créer un nouveau projet"/></form>
<form action="admin.php"><input type="submit" class="moins" value="Revenir à l'espace d'administration"/></form>

</body>

<?php
	pied();
?>