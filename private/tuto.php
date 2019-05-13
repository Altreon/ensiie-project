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
entete( "Accueil", $id_page );
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

$tutoRepository = new \Tuto\TutoRepository($connection);
//$tutoRepository = new \Tuto\TutoRepository($connection);
$tutos = $tutoRepository->fetchAll();
?>

<h1>Administration des tutos</h1>

<h3>Cliquez sur un tuto pour le modifier ou le supprimer</h3>

<div style="overflow-x:auto;">
    <table>
    	<tr><th>Titre</th><th>Lien du PDF</th></tr>
    	<?php 
    	foreach ($tutos as $tuto) {
    	    echo 
    	    '<tr><td>
                <a href="tutoModification.php?id='.$tuto->getId().'">'.$tuto->getTitre().'</a></td><td>'.$tuto->getPdf().'
             </td></tr>';
    	    
    	}
    	?>
    </table>
</div>
<form action="tutoCreation.php"><input type="submit" class="plus" value="Écrire un Tuto"/></form>
<form action="admin.php"><input type="submit" class="moins" value="Revenir à l'espace d'administration"/></form>

</body>

<?php
	pied();
?>