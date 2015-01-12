<?php

include "DB.inc.php";
include "fctAux.inc_bis.php";

session_start();

if(! isset($_SESSION['login']))
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
	echo "<div class=\"contenu\">\n"; 
	echo "<h2> Consultation de la table Espece </h2>";	
	echo '<table>';
	echo '<tr>';
	echo "<th><a href=\"consultEspece.php\">idesp</a></th>";
	echo "<th><a href=\"consultEspece.php?choixTri=1\">nom</a></th>";
	echo "<th><a href=\"consultEspece.php?choixTri=2\">type</a></th>";
	echo '</tr>'; 

	switch ($_GET['choixTri']) {
		case 1:
			$requete = "select * from espece order by nom";
			break;

		case 2:
			$requete = "select * from espece order by type";
			break;

		default:
			$requete = "select * from espece order by idesp";
			break;
	}

	$db = DB::getInstance();
	$t = $db->select($requete);

	for ($i = 0; $i < count($t); $i++)
	{
		$tuple = $t[$i];
		$class = $i % 2 == 0 ? "impair" : "pair";

		if (isset($_GET['idesp']))
		{
			$idesp = $_GET['idesp'];

			if ($tuple->idesp === $idesp)
			{
				$class = "vert";
			}
		}

		$idesp_descriptif = $tuple->idesp;
		
		
	    echo "<tr class=\"$class\">";
		echo "<td><a href=\"consultDescriptif.php?idesp=$idesp_descriptif\">$tuple->idesp</a></td>";
		echo "<td>$tuple->nom</a></td>";
		echo "<td>$tuple->type</a></td>";
		echo "</tr>";
	}

	$db->close();
	echo "</table>";
	echo "</div>";
}
?>