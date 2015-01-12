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
	echo "<h2> Consultation de la table Troupeau </h2>";	
	echo '<table>';
	echo '<tr>';
	echo "<th><a href=\"consultTroupeau.php\">idtroup</a></th>";
	echo "<th><a href=\"consultTroupeau.php?choixTri=1\">nom</a></th>";
	echo '</tr>'; 

	switch ($_GET['choixTri']) {
		case 1:
			$requete = "select * from troupeau order by nom";
			break;
		default:
			$requete = "select * from troupeau order by idtroup";
			break;
	}

	$db = DB::getInstance();
	$t = $db->select($requete);

	for ($i = 0; $i < count($t); $i++)
	{
		$tuple = $t[$i];
		$class = $i % 2 == 0 ? "impair" : "pair";

		if (isset($_GET['idtroup']))
		{
			$idtroup = $_GET['idtroup'];

			if ($tuple->idtroup === $idtroup)
			{
				$class = "vert";
			}
		}

		$idtroup_descriptif = $tuple->idtroup;
		
		
	    echo "<tr class=\"$class\">";
		echo "<td><a href=\"consultDescriptif.php?idtroup=$idtroup_descriptif\">$tuple->idtroup</a></td>";
		echo "<td>$tuple->nom</a></td>";
		echo "</tr>";
	}

	$db->close();
	echo "</table>";
	echo "</div>";
}
?>