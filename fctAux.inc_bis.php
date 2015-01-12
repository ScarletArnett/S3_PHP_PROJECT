<?php

	function enTete()
	{
	    echo"<html>\n";
	    echo"<head><title>La ferme de Mirabelle</title></head>\n";
	    echo"<link href=\"cowboy.css\" type=\"text/css\" rel=\"stylesheet\">\n";
	    echo"<link href=\"../favicon.gif\" rel=\"shortcut icon\" type=\"image/gif\" />\n";
	    echo"<body>";
	    haut();
	    menu($login);
	}

	function enTeteCo(){
		echo"<html>\n";
	    echo"<link href=\"connexion.css\" type=\"text/css\" rel=\"stylesheet\">\n";
	    echo"<link href=\"../favicon.gif\" rel=\"shortcut icon\" type=\"image/gif\" />\n";
	    echo"<body>";
	}

	function pied()
	{
		echo "</body>\n";
		echo "<footer>\n";
		echo "</footer>\n";
		echo "</html>\n";
	}

	function haut()
	{
	    echo"<div class=\"haut\">\n";
	    echo"<div class=\"hautCentre\">\n";
	    echo "<img src=\"img/bandeau_fond.png\">\n";
	    echo"</div>\n";
	    echo"</div>\n";
	}

	function isLoginOk($login)
	{
	    $login_user = "user";
	    $login_admin = "admin";

	    if ( $login == $login_user || $login == $login_admin )
	    {
	        return true;
	    }
	    else { return false; }
	}

	function isMotDePasseOk($login,$mdp)
	{
	    $user_mdp  = "userpwd" ;
	    $admin_mdp = "adminpwd";

	    if ( isLoginOk($login) )
	    {
	        if ( $mdp == $user_mdp || $mdp == $admin_mdp )
	        {
	            return true;
	        }
	        else { return false; }
	    }
	}

	function niveauDroit($nom) {
	  if ($nom == 'user')   return 1; // Droit commun de consultation 
	  if ($nom == 'admin')  return 2; // Droit d'admin de modification
	  return 0;
	}
    
	function menu(){

	$login = isset($_SESSION['login']) ? $_SESSION['login'] : 'guest';

		// Menu réservé aux USERs, le login est donc passé en paramètres !
		if (niveauDroit($login) == 1) {
			echo "
			<nav>
			    <ul>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			        <u>Consultation</u> </br></br>
			        <li><a href=\"accueil.php\">Accueil</a></li>
			        <li><a href=\"consultTroupeau.php\">Troupeau</a></li>
			        <li><a href=\"consultEspece.php\">Espece</a></li>
			        <li><a href=\"consultDescriptif.php\">Descriptif</a></li>
			        <li><a href=\"bye.php\">Déconnexion</a></li>
			    </ul>
			</nav>";
			}

		// Menu réservé aux ADMINs
		if (niveauDroit($login) == 2) {
		    echo "
			<nav>
				<ul>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <u>Consultation</u> </br></br>
				    <li><a href=\"accueil.php\">Accueil</a></li>
				    <li><a href=\"consultTroupeau.php\">Troupeau</a></li>
				    <li><a href=\"consultEspece.php\">Espece</a></li>
				    <li><a href=\"consultDescriptif.php\">Descriptif</a></li>
				</ul>
				</br></br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<u>Modification</u> </br></br>
				<ul>
				    <li><a href=\"saisie.php\">Requête SQL</a></li>
				    <li><a href=\"majTroupeau.php\">Troupeau</a></li>
				    <li><a href=\"majEspece.php\">Espece</a></li>
				    <li><a href=\"majDescriptif.php\">Descriptif</a></li>
				    <li><a href=\"bye.php\">Déconnexion</a></li>
				</ul>
			</nav>";
		}
	}

?>
