<head>
	<link rel="stylesheet" href="../CSS/connexion.css">
</head>

<?php
include("../inc/session.php");

if (!isset($_POST['connexion'])) {
	?>
	<div class="login-page">
	  	<div class="form">
			<form class="login-form" action="" method="POST">
			  <input name="pseudo" type="text" placeholder="Pseudo" required/>
			  <input name="mdp" type="password" placeholder="Mot de passe" required/>
			  <input name="connexion" type="submit" value="Connexion" />
			</form>
	  	</div>
	</div>
	<?php
}else{ //connexion
    $connecte = create_session($_POST['pseudo'], $_POST['mdp']);
	if($connecte){
	    header("Refresh: 0");
		exit();
	}else{
	    ?><p class="error">Pseudo ou Mot de passe incorrect</p>
	    <div class="login-page">
    	  	<div class="form">
    			<form class="login-form" action="" method="POST">
    			  <input name="pseudo" type="text" placeholder="Pseudo" required/>
    			  <input name="mdp" type="password" placeholder="Mot de passe" required/>
    			  <input name="connexion" type="submit" value="Connexion" />
    			</form>
    	  	</div>
		</div>
	    <?php
	}
}
?>
<body>

<?php
	pied();
?>