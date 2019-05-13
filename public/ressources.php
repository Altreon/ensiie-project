<?php
	$id_page="ressources";
	require("../inc/inc.default.php");
	require("../inc/inc.nav.php");
	require("../src/Tuto/Tuto.php");
	require("../src/Tuto/TutoRepository.php");
	entete("Ressources",$id_page);
	
	navAccueil();

	$TutoRepository = new \Tuto\TutoRepository($connection);
	$tutos = $TutoRepository->fetchAll();
	
	
?>

<div class="round-border">
	<h3>Voici des tutos qui pourront vous aider dans vos projets!</h3>
</div>
<br/>
<?php 
	foreach($tutos as $tuto){
		echo '<div class="round-border">
			<p>'.$tuto->getTitre().'</p>
			<p>'.$tuto->getTexte().'</p>
			<p>
				<a href="../document/Tuto/'.$tuto->getPdf().'>view '.$tuto->getTitre().'.pdf</a>
			</p>
			</div><br/>';
	}
?>

<?php pied(); ?>