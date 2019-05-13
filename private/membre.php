<head>
	<link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

<?php
$id_page="admin";
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

if($_SESSION['role'] != 'a'){ //Si pas administrateur, renvoie vers d'administration
    echo '<h4>Erreur: Vous n\'avez pas la permission d\'accéder à cette page, veuillez contacter un administrateur du site pour toutes questions</h4>';
    echo '<h4>Redirection vers la page d\'administration...</h4>';
    header( "refresh:3;url=admin.php" );
    
    pied();
    
    echo '</body>';
    exit();
}

$dbName = 'realitiie';
$dbUser = 'postgres';
$dbPassword = 'postgres';
$connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

$membreRepository = new \Membre\MembreRepository($connection);
$membres = $membreRepository->fetchAll();

$roles = array('a' => "Administrateur", 'r' => "Membre", 'p' => "Président"); // à compléter si ajout de nouveaux rôles
?>

<h1>Administration des membres</h1>

<h3>Cliquez sur un membre pour le modifier ou le supprimer</h3>

<div style="overflow-x:auto;">
    <table>
    	<tr><th>Nom</th><th>Prénom</th><th>Surnom</th><th>Promotion</th><th>Rôle</th></tr>
    	<?php 
    	foreach ($membres as $membre) {
    	    echo 
    	    '<tr><td>
                <a href="membreModification.php?id='.$membre->getId().'">'.$membre->getNom().'</a></td><td>'.$membre->getPrenom().'</td><td>'.$membre->getSurnom().'</td><td>'.$membre->getPromo().'</td><td>'.$roles[$membre->getRole()].'
             </td></tr>';
    	}
    	?>
    </table>
</div>
<form action="membreCreation.php"><input type="submit" class="plus" value="Créer un Membre"/></form>
<form action="admin.php"><input type="submit" class="moins" value="Revenir à l'espace d'administration"/></form>

</body>

<?php
	pied();
?>