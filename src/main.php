<?php
//include("authentication.php");
include("viewfunctions.php");
include("annonce.php");
login();

header_t("Bienvenue sur le site des bons bails");

displayLogin();

if(verif_authent()) { // si le gars est authentified ==>  acces aux offres
    //indexco();
    $annonces = Annonce::getAnnonces();
    foreach ($annonces as $an) {
	$an->display();
    }
} else {	// sinon pas acces aux offres
    indexnotco();
}

footer();
?>
