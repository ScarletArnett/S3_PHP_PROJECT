<?php

include "DB.inc.php";
include "fctAux.inc_bis.php";

session_start();

// Vérifie bien qu'il possède les DROITS ADMIN
if(! isset($_SESSION['login']) && $_SESSION['droit'] != 2)
{	
	// Il ne les a pas donc renvoi vers la connexion
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
	echo "<th><a href=\"majDescriptif.php\">idtroup</a></th>";
	echo "<th><a href=\"majDescriptif.php?choixTri=1\">idesp</a></th>";
	echo "<th><a href=\"majDescriptif.php?choixTri=2\">sexe</a></th>";
	echo "<th><a href=\"majDescriptif.php?choixTri=3\">nombre</a></th>";
	echo "<th></th>\n<th></th>\n";
	echo '</tr>'; 


	// Déclaration des variables + sécurités grâce à Isset et au IF Condensé
	$choixTri    = isset($_GET['choixTri']  ) ? $_GET['choixTri'] : ''    ;
	$delete      = isset($_GET['delete']    ) ? $_GET['delete'] : ''      ;
	$reponse     = isset($_GET['reponse']   ) ? $_GET['reponse'] : ''     ; 
	$delete_esp  = isset($_GET['delete_esp']) ? $_GET['delete_esp'] : ''  ;
	$delete_sex  = isset($_GET['delete_sex']) ? $_GET['delete_sex'] : ''  ;  
	$update_esp  = isset($_GET['update_esp']) ? $_GET['update_esp'] : ''  ;
	$update_sex  = isset($_GET['update_sex']) ? $_GET['update_sex'] : ''  ;
	$update      = isset($_GET['update']    ) ? $_GET['update'] : ''      ;
	$idesp       = isset($_GET['idesp']     ) ? $_GET['idesp'] : ''       ;
	$idtroup     = isset($_GET['idtroup']   ) ? $_GET['idtroup'] : ''     ;
	$sexe        = isset($_GET['sexe']      ) ? $_GET['sexe'] : ''        ;
	$nombre      = isset($_GET['nombre']    ) ? $_GET['nombre'] : ''      ;
	$idespMAJ    = isset($_GET['idespMAJ']  ) ? $_GET['idespMAJ'] : ''    ; 
	$idtroupMAJ  = isset($_GET['idtroupMAJ']) ? $_GET['idtroupMAJ'] : ''  ;
	$idespINS    = isset($_GET['idespINS']  ) ? $_GET['idespINS'] : ''    ; 
	$idtroupINS  = isset($_GET['idtroupINS']) ? $_GET['idtroupINS'] : ''  ; 


	switch ($choixTri) {
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


	$db = DB::getInstance();


	if ($delete != NULL)
	{
		$requeteMaj = "DELETE FROM descriptif WHERE idtroup=$delete AND idesp=$delete_esp AND sexe='$delete_sex'";
		$reponse = $db->maj($requeteMaj);

		// Permet l'affichage d'un erreur claire, lors d'un erreur SQL
		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur de suppression, vous ne pouvez supprimer ce tuple.\n
				  Il est probablement lié.";
			echo "</div>\n";
		}
	}

	if ( $idespMAJ != NULL && $idtroupMAJ != NULL ) {
		$requeteMaj = "UPDATE descriptif SET nombre=$nombre WHERE idesp=$idespMAJ AND idtroup=$idtroupMAJ;";
		$reponse = $db->maj($requeteMaj);

		// Permet l'affichage d'un erreur claire, lors d'un erreur SQL
		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur de modification, vous ne pouvez modifier ce tuple.\n
				  Il est probablement lié.";
			echo "</div>\n";
		}
	}	

	if ( $idespINS != NULL && $idtroupINS != NULL) {
		$requeteMaj = "INSERT INTO descriptif VALUES ($idtroup, $idesp, lower('$sexe'),'$nombre');";
		$reponse = $db->maj($requeteMaj);

		// Permet l'affichage d'un erreur claire, lors d'un erreur SQL
		if ( $reponse == NULL ){
			echo "<div style=\"color:red;\">";
			echo "Erreur d'insertion, vous ne pouvez inserer ce tuple: </br>\n
				  &emsp;- Un des identifiants existe probablement déjà </br>
				  &emsp;- Faites attention à l'orthographe de \"mâle\" </br>
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

			if ($tuple->idesp === $idesp && $tuple->idtroup === $idtroup )
			{
				$class = "vert";
			}
		}


		// Affectation des variables "local" donc les basiques de chaque tuple
		$idtroup = $tuple->idtroup;
		$idesp   = $tuple->idesp  ;
		$sexe    = $tuple->sexe;
		
	   // Vérification de l'existence de la demande 
		if ( $idesp == $update_esp && $idtroup == $update && $sexe == $update_sex ) {
			echo "<tr class=\"$class\">";
			echo "<form action=\"majDescriptif.php\" method=\"get\">\n";

			// Sauvegarde du choix de tri en Hidden et affectations
			echo "<input type=\"hidden\" name=\"choixTri\" value=$choixTri>";
			echo "<input type=\"hidden\" name=\"idtroupMAJ\" value=$update>";
			echo "<input type=\"hidden\" name=\"idespMAJ\" value=$update_esp>";

			// Clés primaires donc non modifiables par update
			echo "<td><a href=\"consultTroupeau.php?idtroup=$update\">$tuple->idtroup</a></td>";
			echo "<td><a href=\"consultEspece.php?idesp=$update_esp\">$tuple->idesp</a></td>";
			echo "<td>$tuple->sexe</a></td>\n";

			// Update donc création d'input et d'un bouton de reset ( origine )
			// et d'un bouton de validation 
			echo "<td><input name=\"nombre\" value=\"$tuple->nombre\"></td>\n";
			echo "<td><input type=\"reset\" value=\"Annuler\"></td>\n";
			echo "<td><input type=\"submit\" name=\"updateKey\" value=\"Valider\"></td>\n";
			echo "</form>\n";
			echo "</tr>\n";
			
		}
		else {
			echo "<tr class=\"$class\">\n";
			echo "<td><a href=\"consultTroupeau.php?idtroup=$idtroup\">$tuple->idtroup</a></td>";
			echo "<td><a href=\"consultEspece.php?idesp=$idesp\">$tuple->idesp</a></td>";
			echo "<td>$tuple->sexe</a></td>";
			echo "<td>$tuple->nombre</a></td>";
			echo "<td><a href=\"majDescriptif.php?choixTri=0&delete=$idtroup&delete_esp=$idesp&delete_sex=$sexe\">supprimer</a>\n";
			echo "<td><a href=\"majDescriptif.php?choixTri=0&update=$idtroup&update_esp=$idesp&update_sex=$sexe\">MAJ</a>\n";
			echo "</tr>";
		}
	}

	// Création de la ligne en bas en permanence
	echo "<tr class=\"impair\">\n";
	echo "<form action=\"majDescriptif.php\" method=\"get\">\n";
	echo "<input type=\"hidden\" name=\"idtroupINS\" value=$idtroup>";
	echo "<input type=\"hidden\" name=\"idespINS\" value=$idesp>";
	echo "<td><input name=\"idtroup\" value=\"\"></td>\n";
	echo "<td><input name=\"idesp\" value=\"\"></td>\n";
	echo "<td><input name=\"sexe\" value=\"\"></td>\n";
	echo "<td><input name=\"nombre\" value=\"\"></td>\n";
	echo "<td><input type=\"reset\" value=\"Annuler\"></td>\n";
	echo "<td><input type=\"submit\" name=\"updateKey\" value=\"Valider\"></td>\n";
	echo "</form>\n";
	echo "</tr>\n";

	$db->close();
	echo "</table>";
	echo "</div>";
}
?>