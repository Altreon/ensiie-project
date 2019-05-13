<?php
	$id_page="debrief";
	require("../inc/inc.default.php");
	require("../inc/inc.nav.php");
	require("../src/Article/Article.php");
	require("../src/Article/ArticleRepository.php");
	require("../src/Membre/Membre.php");
	entete("Comptes-rendus",$id_page);
	
	
	navAccueil();
	
	$dbName = 'realitiie';
	$dbUser = 'postgres';
	$dbPassword = 'postgres';
	$connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

	$articleRepository = new \Article\ArticleRepository($connection);
	$articles = $articleRepository->fetchCompteRendu();
?>

<?php
	$i = 2;
	foreach($articles as $article){
		if ($i == 1)
			$i = 2;
		else
			$i = 1;
		
		echo '<div class="CR-border'.$i.'">';
		echo '<h3>'.$article->getTitre().'</h3>';
		echo $article->getTexte();
		echo '<p> Auteur : '.$article->getAuteur()->getSurnom().'</p>';
		echo '</div><p></p>';
	}
?>

<?php pied(); ?>