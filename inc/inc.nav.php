<?php
function navAccueil()
{
	echo "\t<nav>\n";
	echo "\t<div class=navigation>";
	$date = date( "d/m/Y" );
	
	if( isset( $_SESSION['pseudo'] ) )
	{
		echo "\t<a href=\"../public/deconnexion.php\"><img class=\"boutton_co\" src=\"../img/bouton_deco.png\"></button></a>\n";
		echo "\t<p> Bonjour ".$_SESSION['pseudo']."</p>\n";
		echo "<p>Date : $date</p>";
	}
	else
	{
		echo "\t<a href=\"../public/connexion.php\"><button type=\"button\" class=\"bDecoCo\">Connexion</button></a>\n";
		echo "<p>Date : $date</p>";
	}
	echo "</div>";
	echo "\t</nav>\n";
	echo "<article>\n";
}
?>