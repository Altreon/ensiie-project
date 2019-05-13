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
entete( "Administration" , $id_page);
navAccueil();

if(!isset($_SESSION['pseudo'])){ //Si pas connecté, renvoie vers la page de connexion
    require( "../inc/connexionForm.php" );
    exit();
}

$membreRepository = new \Membre\MembreRepository($connection);
$membre = $membreRepository->getMembre($_SESSION['id']);

$roles = array('a' => "Administrateur", 'r' => "Membre"); // à compléter si ajout de nouveaux rôles

if(isset($_POST['modification'])){ //Si membre est modfifié, modification de la bdd puis renvoie vers la page de d'administration
    $status = $membreRepository->setMembre($_SESSION['id'], $_POST['nom'], $_POST['prenom'], $_POST['surnom'], "", $_POST['promo'], $_POST['role']);
    
    if($status){
        echo '<h4>Vous informations ont bien été modifiées</h4>';
    }else{
        echo '<h4>Erreur: la modification de vos informations a échoué!</h4>';
    }
    
    echo '<h4>Redirection vers la page d\'administration...</h4>';
    header( "refresh:3;url=admin.php" );
    
}else if(isset($_POST['modificationMdp'])){ //Si mot de passe est modifié, modification de la bdd puis rechargement de la page de d'administration  
    if($membreRepository->authentication($membre->getSurnom(), $_POST['old_password']) == null){
        echo '<h4>L\'ancien mot de passe ne correspond pas, veuillez réessayer</h4>';
    }else if($_POST['password'] == $_POST['conf_password']){
        $status = $membreRepository->setMembrePassword($_SESSION['id'], $_POST['password']);
        
        if($status){
            echo '<h4>Le mot de passe a bien été modifié</h4>';
        }else{
            echo '<h4>Erreur: le changement du mot de passe a échoué!</h4>';
        }
    }else{
        echo '<h4>Les deux mot de passes sont différents, veuillez réessayer</h4>';
    }
    
    echo '<h4>Redirection vers la page d\'administration...</h4>';
    header( "refresh:3;url=admin.php" );
}else{

    ?>
    
    <h1>Page d'administration</h1>
    
    <br/><br/>
    
    <h2>Bienvenue sur la page d'administration du site de l'association de Realitiie</h2>
    <br/>
    <h2>Choissiez quelle partie du site vous souhaitez éditer :</h2>
    <br/><br/><br/>
    
    <form action="article.php"><input type="submit" class="admin" value="Articles"/></form>
    <form action="jeux.php"><input class="admin" type="submit" value="Projets"/></form>
    <form action="tuto.php"><input class="admin" type="submit" value="Tutos"/></form>
    
    <?php if($_SESSION['role'] == 'a'){?>
    	<form action="membre.php"><input class="admin" type="submit" value="Membres"/></form>
    <?php } ?>
    
    <br/><br/><br/>
    <h3>Vous pouvez changer vos information ici :</h3>
    
    <div class="modifContainer">
    	<form action="" method="POST">
        	<label>Nom : </label><input name="nom" type="text" value="<?php echo $membre->getNom() ?>" required/>
        	<br/>
        	<label>Prénom : </label><input name="prenom" type="text" value="<?php echo $membre->getPrenom() ?>" required/>
        	<br/>
        	<label>Surnon : </label><input name="surnom" type="text" value="<?php echo $membre->getSurnom() ?>" required/>
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
        	<input type="submit" name="modification" value="Envoyer"/>
        </form>
    </div>
    
    <br><br>
    
    <h4>Changer de mot de passe :</h4>
    <form action="" method="POST">
    	<label>Ancien mot de passe : </label><input name="old_password" type="password" required/>
    	<label>Nouveau mot de passe : </label><input name="password" type="password" required/>
    	<label>Confirmer nouveau mot de passe : </label><input name="conf_password" type="password" required/>
    	<input type="submit" name="modificationMdp" value="Envoyer"/>
    </form>
    
    <?php
}
?>
</body>

<?php
	pied();
?>
