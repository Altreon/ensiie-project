<?php
	session_start();
	require("../inc/session.php");
	if( isset( $_SESSION['pseudo'] ) )
	{
		destroy_session();
		header( "location:../public/index.php");
	}
	else
	{
		header( "location:../public/index.php");
	}
?>