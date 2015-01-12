<?php

session_start();
include "fctAux.inc_bis.php";
enTete();
contenu();
pied();

function contenu () {
  echo "<div class=\"contenu\">\n";
  /*echo "TP SYNTHESE WEBAPP - Alexandre BAPTISTE\n Fichier attaché: rapport.pdf";*/
  echo "</br></br></br></br></br></br>
	  	<i>
	  	<span style= \"color: red;\">L</span>a danse des flocons blancs </br>
		<span style= \"color: red;\">L</span>a neige fait danser</br>
		<span style= \"color: red;\">T</span>ous ses flocons légers.</br></br>

		<span style= \"color: red;\">V</span>ient se mêler le vent</br>
		<span style= \"color: red;\">A</span>u bal des flocons blancs.</br></br>

		<span style= \"color: red;\">P</span>rend la main d'un flocon</br>
		<span style= \"color: red;\">E</span>t danse en tourbillon.</br></br>

		<span style= \"color: red;\">L</span>'emporte loin d'ici</br>
		<span style= \"color: red;\">E</span>t en fait son ami.</i></br>"; 
  echo "<div class=\"video\">\n";
  echo "<video controls src=\"img/test.mp4\">";
  echo "</div>\n";
  echo "<div class=\"video2\">\n";
  echo "<video controls src=\"img/last_xmas.mp4\">";
  echo "</div>\n";
  echo "</div>\n";
}
?>