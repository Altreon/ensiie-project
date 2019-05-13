<?php
	$id_page="equipe";
	require( "../inc/inc.default.php" );
	require( "../inc/inc.nav.php" );
	require( "../src/Membre/Membre.php");
	require( "../src/Membre/MembreRepository.php");
	entete( "Equipe" ,$id_page);
	navAccueil();
	
	$dbName = 'realitiie';
	$dbUser = 'postgres';
	$dbPassword = 'postgres';
	$connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

	$membreRepository = new \Membre\MembreRepository($connection);
	$membres = $membreRepository->fetchAll();
	
	
?>

<h2>NOTRE EQUIPE</h2>
<div>
    <div class="round-border"> 
	
		<h3>Le président</h3>

			<p><b>Plou</b>, règnant en tyrant est là pour nous montrer la voie à suivre. Fort de sa dernière participation
			au Laval virtual il sera chargé d'organiser les tutos et vous entrainer pour pouvoir profiter vous même de l'expérience.</p>
		
		<h4>Son bureau</h4>
			<p><b>Trésorier : Jalik</b>, ayant pour unique objectif de partir avec la caisse, mais pas avant de l'avoir entièrement dépensée en matériel
			pour l'association. Le budget de l'association est à dépenser et c'est à vous de proposer ce qu'il faut acheter.</p>
			
			<p><b>Secrétaire Général : DBA3</b>, du moins quand il n'est pas entrain de mettre des B-coté sur smash bros ultimate, vous pouvez compter sur lui pour
			recevoir les compte-rendus des réunions.</p>

	</div>
	
	<div>		
		<h3>Ainsi que le reste des membres</h3>
		<table>
			<tr><th></th><th>Surnom</th><th>Prénom</th><th>Nom</th></tr>
			
			<?php
			foreach ($membres as $membre) {
				$img = $membre->getSurnom();
				$img = "../img/membres/".$img.".png";
				if(file_exists($img) == false){
					$img = "../img/badassChicken.png";
				}
					
				echo 
				'<tr>
					<td><img src='.$img.' alt="404 : people not found" width="150" height="150"/></td>
					<td>'.$membre->getSurnom().'</td>
					<td>'.$membre->getPrenom().'</td>
					<td>'.$membre->getNom().'</td>
				</tr>';
			}
			?>
		</table>
	</div>
</div>


<?php
	pied();
?>