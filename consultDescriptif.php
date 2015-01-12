<?php

include "DB.inc.php";
include "fctAux.inc_bis.php";

// Placé au début de chaque page afin de vérifier que l'user soit bien log(arg)
session_start();

if(! isset($_SESSION['login']))
{
	header('Location: connexion_bis.php');
}

else {
	entete();
	contenu();
	pied();
}

function contenu()
{
	echo "<div class=\"contenu\">\n"; 
	echo "<h2> Consultation de la table Descriptif </h2>";	
	echo '<table>';
	echo '<tr>';
	echo "<th><a href=\"consultDescriptif.php\">idtroup</a></th>";
	echo "<th><a href=\"consultDescriptif.php?choixTri=1\">idesp</a></th>";
	echo "<th><a href=\"consultDescriptif.php?choixTri=2\">sexe</a></th>";
	echo "<th><a href=\"consultDescriptif.php?choixTri=3\">nombre</a></th>";
	echo '</tr>'; 

	// Switch sur le choix du tri grâce à au nombre données dans l'URL des TH
	// grâce à $_GET
	switch ($_GET['choixTri']) {
		case 1:
			$requete = "select * from descriptif order by idesp";
			break;

		case 2:
			$requete = "select * from descriptif order by sexe";
			break;

		case 3:
			$requete = "select * from descriptif order by nombre";
			break;

		default:
			$requete = "select * from descriptif order by idtroup";
			break;
	}

	// Exécution des requêtes sur la BD
	$db = DB::getInstance();
	$t = $db->select($requete);


	// Boucle permettant l'affichage de chaque tuple
	for ($i = 0; $i < count($t); $i++)
	{
		$tuple = $t[$i];
		// Permet le changement de couleur de chaque ligne du tableau
		$class = $i % 2 == 0 ? "impair" : "pair";

		// Vérification de l'existance, et si la valeur est la même alors 
		// colorisation en VERT grâce à $class
		if (isset($_GET['idesp']))
		{
			$idesp = $_GET['idesp'];

			if ($tuple->idesp === $idesp)
			{
				$class = "vert";
			}
		}

		if (isset($_GET['idtroup']))
		{
			$idtroup = $_GET['idtroup'];

			if ($tuple->idtroup === $idtroup)
			{
				$class = "vert";
			}
		}

		// Déclaration des variables en relation avec les autres tables
		$idesp_espece = $tuple->idesp;
		$idtroup_troupeau = $tuple->idtroup;
		
		// Création des lignes de la tables et permalien
	    echo "<tr class=\"$class\">";
		echo "<td><a href=\"consultTroupeau.php?idtroup=$idtroup_troupeau\">$tuple->idtroup</a></td>";
		echo "<td><a href=\"consultEspece.php?idesp=$idesp_espece\">$tuple->idesp</a></td>";
		echo "<td>$tuple->sexe</a></td>";
		echo "<td>$tuple->nombre</a></td>";
		echo "</tr>";
	}

	// Fermeture de la connexion à la BD et de la table.
	$db->close();
	echo "</table>";
	echo "</div>";
}
?>