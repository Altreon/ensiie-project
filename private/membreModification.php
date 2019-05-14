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

if(!isset($_GET['id'])){ //Si aucun membre selectionné, renvoie vers la page de d'administration des membres
    header("location: membre.php");
}

$dbName = 'realitiie';
$dbUser = 'postgres';
$dbPassword = 'postgres';
$connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

$membreRepository = new \Membre\MembreRepository($connection);

$membre = $membreRepository->getMembre($_GET['id']);

$roles = array('a' => "Administrateur", 'r' => "Membre"); // à compléter si ajout de nouveaux rôles

if($membre == NULL){ //Si membre introuvable, renvoie vers la page de d'administration des membres
    echo '<h4>Erreur: le membre n°'.$_GET['id'].' est introuvable!</h4>';
    echo '<h4>Redirection vers la liste des membres...</h4>';
    header( "refresh:3;url=membre.php" );
}else if(isset($_POST['modification'])){ //Si membre est modfifié, modification de la bdd puis renvoie vers la page de d'administration des membres
    $status = $membreRepository->setMembre($_GET['id'], $_POST['nom'], $_POST['prenom'], $_POST['surnom'], $_POST['password'], $_POST['promo'], $_POST['role']);
    
    if($status){
        echo '<h4>Le membre n°'.$_GET['id'].' a bien été modifié</h4>';
    }else{
        echo '<h4>Erreur: la modification du membre n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des membres...</h4>';
    header( "refresh:3;url=membre.php" );
}else if(isset($_POST['supression'])){ //Si membre est supprimé, modification de la bdd puis renvoie vers la page de d'administration des membres
	$membreRepository->deleteAllMedia($_GET['id']);
	$status = $membreRepository->deleteMembre($_GET['id']);
    
    if($status){
        echo '<h4>Le membre n°'.$_GET['id'].' a bien été supprimé</h4>';
    }else{
        echo '<h4>Erreur: la supression du membre n°'.$_GET['id'].' a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la liste des membres...</h4>';
    header( "refresh:3;url=membre.php" );
}else{

    echo '<h1>Modification du membre n°'.$membre->getId().'</h1>';
                
    ?>
    <div class="modifContainer">
    	<form action="" method="POST">
        	<label>Nom : </label><input name="nom" type="text" value="<?php echo $membre->getNom() ?>" required/>
        	<br/>
        	<label>Prénom : </label><input name="prenom" type="text" value="<?php echo $membre->getPrenom() ?>" required/>
        	<br/>
        	<label>Surnon : </label><input name="surnom" type="text" value="<?php echo $membre->getSurnom() ?>" required/>
        	<br/>
        	<label>Mot de passe (laissez vide pour ne pas modifier) : </label><input name="password" type="password"/>
        	<br/>
        	<label>promo : </label>
        	<select name="promo" required>
        		<?php
        		foreach (range(date("Y") + 3, 1968, 1) as $promo){
        		    if($promo == $membre->getPromo()){
        		        echo '<option value="'.$promo.'" selected>'.$promo.'</option>';
        		    }else{
        		        echo '<option value="'.$promo.'">'.$promo.'</option>';
        		    }
        		}
        		?>
        	</select>
        	<br/>
        	<label>role : </label>
        	<select name="role" required>
        		<?php
        		foreach ($roles as $roleChar => $roleName){
        		    if($roleChar == $membre->getRole()){
        		        echo '<option value="'.$roleChar.'" selected>'.$roleName.'</option>';
        		    }else{
        		        echo '<option value="'.$roleChar.'">'.$roleName.'</option>';
        		    }
        		}
        		?>
        	</select>
			<?php
				echo '<a href="../private/mediaModification.php?idMembre='.$membre->getId().'" >Modifier la photo de profil</a>';
			?>
        	<input type="submit" name="modification" value="Envoyer"/>
        </form>
    </div>
    
    <form action="" method="POST"><input name ="supression" type="submit" class="moins" value="Supprimer le membre"/></form>
 
<?php
}
?>

</body>

<?php
	pied();
?>