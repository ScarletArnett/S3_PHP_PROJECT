<?php

include "DB.inc.php";
include "fctAux.inc_bis.php";

session_start();

if(! isset($_SESSION['login']) && $_SESSION['droit'] != 2 )
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
	echo "<h2> Consultation de la table Espece </h2>";	
	echo '<table>';
	echo '<tr>';
	echo "<th><a href=\"majEspece.php\">idesp</a></th>";
	echo "<th><a href=\"majEspece.php?choixTri=1\">nom</a></th>";
	echo "<th><a href=\"majEspece.php?choixTri=2\">type</a></th>";
	echo "<th></th>\n<th></th>\n";
	echo '</tr>'; 

	$choixTri    = isset($_GET['choixTri']  ) ? $_GET['choixTri'] : ''    ;
	$delete      = isset($_GET['delete']    ) ? $_GET['delete'] : ''      ;
	$update      = isset($_GET['update']    ) ? $_GET['update'] : ''      ;
	$idesp       = isset($_GET['idesp']     ) ? $_GET['idesp'] : ''       ;
	$nom         = isset($_GET['nom']       ) ? $_GET['nom'] : ''         ;
	$type        = isset($_GET['type']      ) ? $_GET['type'] : ''        ;
	$idespMAJ    = isset($_GET['idespMAJ']  ) ? $_GET['idespMAJ'] : ''    ;
	$idespINS    = isset($_GET['idespINS']  ) ? $_GET['idespINS'] : ''    ;


	switch ($choixTri) {
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


	if ($delete != NULL)
	{
		$requeteMaj = "delete from espece where idesp=$delete";
		$reponse = $db->maj($requeteMaj);

		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur de suppression, vous ne pouvez supprimer ce tuple.\n
				  Il est probablement lié.";
			echo "</div>\n";
		}
	}

	if ( $idespMAJ != NULL ) {
		$requeteMaj = "UPDATE espece SET nom=lower('$nom'), type=lower('$type') WHERE idesp=$idespMAJ;";
		$reponse = $db->maj($requeteMaj);

		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur de moficication, vous ne pouvez modifier ce tuple.\n
				  Il est probablement lié.";
			echo "</div>\n";
		}
	}	

	if ( $idespINS != NULL ) {
		$requeteMaj = "INSERT INTO espece VALUES ($idesp,lower('$nom'),lower('$type'));";
		$reponse = $db->maj($requeteMaj);

		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur d'insertion, vous ne pouvez inserer ce tuple: </br>\n
				  &emsp;- Un des identifiants existe probablement déjà </br>
				  &emsp;- Vous avez mal écrit \"carnivore, herbivore ou omnivore\" </br>
				  &emsp;- Veuillez ne pas laisser de cases vides";
			echo "</div>\n";
		}
	}

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

		

		$idesp = $tuple->idesp;
		
	   
		if ( $idesp == $update ) {
			echo "<tr class=\"$class\">";
			echo "<form action=\"majEspece.php\" method=\"get\">\n";
			echo "<input type=\"hidden\" name=\"choixTri\" value=$choixTri>";
			echo "<input type=\"hidden\" name=\"idespMAJ\" value=$update>";
			echo "<td><a href=\"consultDescriptif.php?idesp=$idespMAJ\">$tuple->idesp</a></td>";
			echo "<td><input name=\"nom\" value=\"$tuple->nom\"></td>\n";
			echo "<td><input name=\"type\" value=\"$tuple->type\"></td>\n";
			echo "<td><input type=\"reset\" value=\"Annuler\"></td>\n";
			echo "<td><input type=\"submit\" name=\"updateKey\" value=\"Valider\"></td>\n";
			echo "</form>\n";
			echo "</tr>\n";

			
		}
		else {
			echo "<tr class=\"$class\">\n";
			echo "<td><a href=\"consultDescriptif.php?idesp=$idesp\">$tuple->idesp</a></td>";
			echo "<td>$tuple->nom</a></td>";
			echo "<td>$tuple->type</a></td>";	
			echo "<td><a href=\"majEspece.php?choixTri=0&delete=$idesp\">supprimer</a>\n";
			echo "<td><a href=\"majEspece.php?choixTri=0&update=$idesp\">MAJ</a>\n";
			echo "</tr>";
		}
	}

	echo "<tr class=\"impair\">\n";
	echo "<form action=\"majEspece.php\" method=\"get\">\n";
	echo "<input type=\"hidden\" name=\"idespINS\" value=$idesp>";
	echo "<td><input name=\"idesp\" value=\"\"></td>\n";
	echo "<td><input name=\"nom\" value=\"\"></td>\n";
	echo "<td><input name=\"type\" value=\"\"></td>\n";
	echo "<td><input type=\"reset\" value=\"Annuler\"></td>\n";
	echo "<td><input type=\"submit\" name=\"updateKey\" value=\"Valider\"></td>\n";
	echo "</form>\n";
	echo "</tr>\n";


	$db->close();
	echo "</table>";
	echo "</div>";
}
?>