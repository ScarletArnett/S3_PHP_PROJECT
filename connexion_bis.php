<?php

include "fctAux.inc_bis.php";

// Initialisation des variables et utilisation de htmlentities qui
// convertit tous les caractères en "entités HTML" pour éviter des
// problème de caractères.
$login = isset($_POST['login']) ? htmlentities($_POST['login']) : '';
$mdp   = isset($_POST['mdp']) ? htmlentities($_POST['mdp']) : '';

function formulaire($error, $def)
{
  // En tête spéciale pour ce formulaire
  // ( Background et centré )
  enTeteCo();
  echo "
	<div class=\"contenu\">
	    <form  action=\"connexion_bis.php\" method=\"post\">
	    <div class =\"error\"> $error </div>
	        <fieldset>
	            <legend>Connexion</legend>
	            <label for=\"login\">Login   <em>*</em>
              </label><input autofocus=\"\" placeholder=\"xxxxxx\"value=\"$def\"
                       required=\"\" type=\"text\" name=\"login\"/><br/>

	            <label for=\"mdp\">Password<em>*</em>
              </label><input placeholder=\"&bull;&bull;&bull;&bull;&bull;&bull;\" 
                      autofocus=\"\" required=\"\" type=\"password\" name=\"mdp\"/><br/>

	            <input type=\"submit\" value=\"Valider\"/>
	            <input type=\"reset\" value=\"Annuler\"/>
	        </fieldset>
	    </form>
	</div>";
	pied();
}


// Vérification 
if ( isset($_POST['login']) )
{
  if ( isLoginOk($login) )
  {
    if ( isMotDePasseOk($login,$mdp) )
    {
      // Si tout est OK pour USER
      if ( $login == "user" & $mdp == "userpwd" )
      {
        // Création de session et envoi du Login et Droit
        session_start();
        $_SESSION['login']= htmlentities($login);
        $_SESSION['droit']= niveauDroit($login) ;

        // Redirection grâce à la fonction header 
        header("Location: accueil.php");
      }
      // Si tout est OK pour ADMIN
      else if ( $login == "admin" & $mdp == "adminpwd")
      {
        session_start();
        $_SESSION['login']=htmlentities($login);
        $_SESSION['droit']=niveauDroit($login);
        header("Location: accueil.php");
      }

      // Gestion des erreurs
      else {
        formulaire("password incorrect",$login);
      }
    }
    else {
      formulaire("password incorrect",$login);
    }
  }
  else {
    formulaire("login incorrect","");
  }
} else {
  formulaire("", "");
}

?>