<?php
    $dbName = 'realitiie';
    $dbUser = 'postgres';
    $dbPassword = 'postgres';
    $connection = new PDO("pgsql:host=localhost user=$dbUser dbname=$dbName password=$dbPassword");

	$request = "SELECT id_membre, surnom FROM membre";
	$result = $connection->query($request);
	$result->fetch(PDO::FETCH_ASSOC);
	foreach( $result as $membre )
	{
		$a[] = $membre;
	}
	$send = json_encode($a);
	echo $send;
?>
