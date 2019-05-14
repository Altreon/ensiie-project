<?php
    $id_page="projet";
	require("../inc/inc.default.php");
	require("../inc/inc.nav.php");
	
	
	$dbName = 'realitiie';
	$dbUser = 'postgres';
	$dbPassword = 'postgres';
	$connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");
	
	require("../src/Jeu/Jeu.php");
	require("../src/Jeu/JeuRepository.php");
	require("../src/Equipe/Equipe.php");
	require("../src/Equipe/EquipeRepository.php");
	require("../src/Membre/Membre.php");
	require("../src/Membre/MembreRepository.php");
	//require("../src/Article/Article.php");
	//require("../src/Article/ArticleRepository.php");
	require("../src/Miseajour/Miseajour.php");
	require("../src/Miseajour/MiseajourRepository.php");
	
	$JeuRepository = new \Jeu\JeuRepository($connection);
	$EquipeRepository = new \Equipe\EquipeRepository($connection);
	//$ArticleRepository = new \Article\ArticleRepository($connection);
	$MembreRepository = new \Membre\MembreRepository($connection);
	$MiseajourRepository = new \Miseajour\MiseajourRepository($connection);
	
	if(!isset($_GET['id'])){
		header("location: projet.php");
	}
	$jeu = $JeuRepository->getJeu($_GET['id']);
	
	if($jeu == NULL){
		echo '<h4>Erreur: le jeu n°'.$_GET['id'].' est introuvable!</h4>';
		echo '<h4>Redirection vers la liste des jeux...</h4>';
		header( "refresh:3;url=projet.php" );
	}
	
	$idjeu = $jeu->getId();
	$equipe = $EquipeRepository->getEquipe($idjeu);
	$maj = $MiseajourRepository->fetchAllFromJeu($idjeu);
	
	entete( $jeu->getTitre(), $id_page );
	navAccueil();
?>

<div>
	<?php
	echo '<h1>'.$jeu->getTitre().'</h1>';
	
	$imgs = $JeuRepository->getMedias($jeu->getId());
	foreach($imgs as $img){
		if(file_exists($img) == true){
				echo '<img src='.$img.' alt="img not found" width="100" height="100"/>'; 
		}
	}
	?>
</div>

<div class="round-border">

	<?php
	echo '<h2>Description :</h2>
		<p>'.$jeu->getDescription().'</p>
	<p> Ce magnifique jeu a été réalisé par :
		<ul>';
			foreach ($equipe->getMembres() as $mem){
				echo '<li>'.$mem->getSurnom().' : '.$equipe->getRole($mem->getId()).'</li>';
			}
		echo '</ul>
	</p>
	<p> Vous pouvez le télécharger ici : 
		<a href=../data/jeux/'.$jeu->getTelechargement().' download='.$jeu->getTitre().'>Votre jeu trop bien!!</a></p>';
	?>
</div>
</br>
<div class="round-border">
	<h2>Mise à jour du jeu</h2>
	<?php
		if(sizeof($maj)==0){
			echo 'Ce jeu n\'a pas encore de mise à jour';
		}
		
		else{
			foreach($maj as $m){
				if ( $m->getDate()->format("d M Y") <= getDate()){
					echo '<h3>Mise à jour du '.$m->getDate()->format("d M Y").'</h3>';
				
					$imgs = $MiseajourRepository->getMedias($m->getId());
					foreach($imgs as $img){
						if(file_exists($img)){
							echo '<img class="media" src="'.$img.'" alt="img not found"/>'; 
						}
					}
				
					echo '<p>'.$m->getTexte().'</p>';
				}
			}
		}
	?>
</div>	

<?php pied(); ?>