<?php

function create_session($pseudo, $mdp){
    $dbName = 'realitiie';
    $dbUser = 'postgres';
    $dbPassword = 'postgres';
    
    $connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

    $membreRepository = new \Membre\MembreRepository($connection);
    
    $membre = $membreRepository->authentication($pseudo, $mdp);

    if($membre == null){
		return false;
	}
	
	session_start();
	$_SESSION['id'] =$membre->getId();
	$_SESSION['pseudo'] = $pseudo;
	$_SESSION['role'] = $membre->getRole();
	
	return true;
}

function destroy_session(){
	$_SESSION['id'] = null;
	$_SESSION['pseudo'] = null;
	$_SESSION['role'] = null;
	session_destroy();
}		

?>
