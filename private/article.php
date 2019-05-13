<head>
	<link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

<?php
$id_page="admin";
require '../src/Article/Article.php';
require '../src/Article/ArticleRepository.php';
require '../src/Membre/Membre.php';
require( "../inc/inc.default.php" );
require( "../inc/inc.nav.php" );
entete( "Accueil" ,$id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

$articleRepository = new \Article\ArticleRepository($connection);;
//$articleRepository = new \Article\ArticleRepository($connection);
$articles = $articleRepository->fetchWithoutTexte();
?>

<h1>Administration des articles</h1>

<h3>Cliquez sur un article pour le modifier ou le supprimer</h3>

<div style="overflow-x:auto;">
    <table>
    	<tr><th>Titre</th><th>Auteur</th><th>Date</th></tr>
    	<?php 
    	foreach ($articles as $article) {
    	    if($_SESSION['role'] == 'a' || $article->getAuteur()->getId() == $_SESSION['id']){
        	    echo 
        	    '<tr><td>
                    <a href="articleModification.php?id='.$article->getId().'">'.$article->getTitre().'</a></td><td>'.$article->getAuteur()->getSurnom().'</td><td>'.$article->getDate()->format('d/m/Y').'
                 </td></tr>';
    	    }
    	}
    	?>
    </table>
</div>
<form action="articleCreation.php"><input type="submit" class="plus" value="Écrire un Article"/></form>
<form action="admin.php"><input type="submit" class="moins" value="Revenir à l'espace d'administration"/></form>

</body>

<?php
	pied();
?>