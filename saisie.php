<?php

include "DB.inc.php";
include "fctAux.inc_bis.php";

session_start();

if(! isset($_SESSION['login']) && $_SESSION['droit'] != 2 )
{
	header('Location: connexion_bis.php');
}

else {
	enTete();
	contenu();
	pied();
}

function contenu()
{
	/*$request = isset($_POST['request']) ? $_GET['request'] : '';*/

	echo "<div class=\"contenu\">\n"; 
	echo "<h2> Tentative d'écriture de requête </h2>";
	echo "<form action=\"saisie.php\" method=\"post\">\n";
	echo "Saisir la requête: </br><textarea name=\"request\" rows=\"5\" cols=\"50\">$request</textarea></br>	";
	echo "<input type=\"submit\" value=\"Valider\">\n";
	echo "</form>\n";

	if (!empty($request)) {
		echo "<p style='color: silver'>Votre dernière requête validée: $request</p>";
		$db = DB::getInstance();
	 	$t = $db->select($request);
	 	$db->close();
	}

 	echo "</div>";

}
?>