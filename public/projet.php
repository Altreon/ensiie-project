<?php
	$id_page="projet";
	require("../inc/inc.default.php");
	require("../inc/inc.nav.php");
	require("../src/Jeu/Jeu.php");
	require("../src/Jeu/JeuRepository.php");
	require("../src/Equipe/Equipe.php");
	require("../src/Equipe/EquipeRepository.php");
	require("../src/Membre/Membre.php");
	
	entete("Projets",$id_page);
	
	
	
	navAccueil();
	
	$dbName = 'realitiie';
	$dbUser = 'postgres';
	$dbPassword = 'postgres';
	$connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

	$JeuRepository = new \Jeu\JeuRepository($connection);	
	$jeux = $JeuRepository->fetchAll();
	$teamRepository = new \Equipe\EquipeRepository($connection);
	
	
	
?>

<h2>PROJETS!</h2>
<div>
<p>Voici ce dont les membres de l'association sont capable!</p>
</div>
<div>
<table>
    	<tr><th></th><th>Titre</th><th>Team</th><th>Git</th><th>Téléchargement</th></tr>
		
		<?php
    	foreach ($jeux as $jeu) {
			$imgs = $JeuRepository->getMedias($jeu->getId());
			if (isset ($imgs[0])){ // Si il y a 1 image au moins
					$img = $imgs[0];
					if(!file_exists($img)){
						$img = "../img/RobotRealitIIE.png";
					}
				}
					
				else
					$img = "../img/RobotRealitIIE.png";
			
    	    echo 
    	    '<tr>
				<td><img class="media" src='.$img.' alt="404 : img not found"/></td>
				<td><a href=../public/jeuDetail.php?id='.$jeu->getId().'>'.$jeu->getTitre().'</a></td>
				<td>';
			
			$team = $teamRepository->getEquipe($jeu->getId());
			echo '<ul>';
			foreach ($team->getMembres() as $mem){
				echo '<li>'.$mem->getSurnom().' : '.$team->getRole($mem->getId()).'</li>';
			}
			echo '</ul>	
			
			</td>
				<td>'.$jeu->getGit().'</td>
				<td><a href=../data/jeux/'.$jeu->getTelechargement().' download='.$jeu->getTitre().'>download</a></td>
			</tr>';
    	}
		
    	?>
    </table>
</div>


<?php pied(); ?>