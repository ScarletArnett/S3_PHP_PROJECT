<?php
	include("fctAux.inc_bis.php");

	session_start();
	session_destroy(); //destruction de la session a la prochaine requete

	header("Location: connexion_bis.php"); //on renvoie vers le formulaire de connexion
?>