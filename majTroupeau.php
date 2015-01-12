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
	echo "<h2> Consultation de la table Troupeau </h2>";	
	echo '<table>';
	echo '<tr>';
	echo "<th><a href=\"majTroupeau.php\">idtroup</a></th>";
	echo "<th><a href=\"majTroupeau.php?choixTri=1\">nom</a></th>";
	echo "<th></th>\n<th></th>\n";
	echo '</tr>'; 

	$choixTri    = isset($_GET['choixTri']  ) ? $_GET['choixTri'] : ''    ;
	$delete      = isset($_GET['delete']    ) ? $_GET['delete'] : ''      ;
	$update      = isset($_GET['update']    ) ? $_GET['update'] : ''      ;
	$idtroup     = isset($_GET['idtroup']   ) ? $_GET['idtroup'] : ''     ;
	$nom         = isset($_GET['nom']       ) ? $_GET['nom'] : ''         ;
	$idtroupMAJ  = isset($_GET['idtroupMAJ']) ? $_GET['idtroupMAJ'] : ''  ;
	$idtroupINS  = isset($_GET['idtroupINS']) ? $_GET['idtroupINS'] : ''  ;  


	switch ($choixTri) {
		case 1:
			$requete = "select * from troupeau order by nom";
			break;
		default:
			$requete = "select * from troupeau";
			break;
	}

	$db = DB::getInstance();


	if ($delete != NULL)
	{
		$requeteMaj = "delete from troupeau where idtroup=$delete";
		$reponse = $db->maj($requeteMaj);

		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur de suppression, vous ne pouvez supprimer ce tuple.\n
				  Il est probablement lié.";
			echo "</div>\n";
		}
	}

	if ( $idtroupMAJ != NULL ) {
		$requeteMaj = "UPDATE troupeau SET nom=lower('$nom') WHERE idtroup=$idtroupMAJ;";
		$reponse = $db->maj($requeteMaj);

		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur de modification, vous ne pouvez modifier ce tuple.\n
				  Il est probablement lié.";
			echo "</div>\n";
		}
	}	

	if ( $idtroupINS != NULL ) {
		$requeteMaj = "INSERT INTO troupeau VALUES ($idtroup,lower('$nom'));";
		$reponse = $db->maj($requeteMaj);

		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">\n";
			echo "Erreur d'insertion, vous ne pouvez inserer ce tuple: </br>
				  &emsp;- Un des identifiants existe probablement déjà </br>
				  &emsp;- Veuillez ne pas laisser de cases vides";
			echo "</div>\n";
		}
	}


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

		$idtroup = $tuple->idtroup;
		
	   
		if ( $idtroup == $update ) {
			echo "<tr class=\"$class\">";
			echo "<form action=\"majTroupeau.php\" method=\"get\">\n";
			echo "<input type=\"hidden\" name=\"choixTri\" value=$choixTri>";
			echo "<input type=\"hidden\" name=\"idtroupMAJ\" value=$update>";
			echo "<td><a href=\"consultTroupeau.php?idtroup=$update\">$tuple->idtroup</a></td>";
			echo "<td><input name=\"nom\" value=\"$tuple->nom\"></td>\n";
			echo "<td><input type=\"reset\" value=\"Annuler\"></td>\n";
			echo "<td><input type=\"submit\" name=\"updateKey\" value=\"Valider\"></td>\n";
			echo "</form>\n";
			echo "</tr>\n";
			
		}
		else {
			echo "<tr class=\"$class\">\n";
			echo "<td><a href=\"consultTroupeau.php?idtroup=$idtroup\">$tuple->idtroup</a></td>";
			echo "<td>$tuple->nom</a></td>";
			echo "<td><a href=\"majTroupeau.php?choixTri=0&delete=$idtroup\">supprimer</a>\n";
			echo "<td><a href=\"majTroupeau.php?choixTri=0&update=$idtroup\">MAJ</a>\n";
			echo "</tr>";
		}
	}

	echo "<tr class=\"impair\">\n";
	echo "<form action=\"majTroupeau.php\" method=\"get\">\n";
	echo "<input type=\"hidden\" name=\"idtroupINS\" value=$idtroup>";
	echo "<td><input name=\"idtroup\" value=\"\"></td>\n";
	echo "<td><input name=\"nom\" value=\"\"></td>\n";
	echo "<td><input type=\"reset\" value=\"Annuler\"></td>\n";
	echo "<td><input type=\"submit\" name=\"updateKey\" value=\"Valider\"></td>\n";
	echo "</form>\n";
	echo "</tr>\n";


	$db->close();
	echo "</table>";
	echo "</div>";
}
?>