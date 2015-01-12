<?php

// classe d'interface avec la base de donnees postgresql
// version avec le pattern Singleton
    class DB{

	private static $instance = null; //memorisation de l'unique instance de la classe DB

	private $connexion;	


	/************************************************************************/
	//	Constructeur gerant  la connexion 
	//	NB : il est non utilisable de l'exterieur
	/************************************************************************/	
	private function __construct() {
		/***** LIGNE A MODIFIER *******/
                $this->connexion=pg_connect("host=localhost dbname=arnett user=arnett password=vidock")
                        or die("Impossible de se connecter");
        }

	/************************************************************************/
	//	Methode permettant d'obtenir un objet instance de DB
	//	NB : cet objet est unique.
	//	NB2: c'est une methode de classe.
	/************************************************************************/
	 public static function getInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new DB();
		}
		return self::$instance;
	}

	/***************************************************************/
        // Fermeture de la connexion
        /***************************************************************/
        public function close(){
                pg_close($this->connexion);
        }

	/***************************************************************/
        // SELECT generique sur une table quelconque
        /***************************************************************/
        public function select($requeteSQL){
		$tab=array();
                $row = 0;
                $reponse = pg_query($this->connexion,$requeteSQL);

                if($reponse == false) {
                    return null;
                }

               	while ($tuple = pg_fetch_object($reponse)){
		      $tab[$row]=$tuple;
		      $row++;
                }       	
                return $tab;
        }

	/***************************************************************/
        // MAJ generique sur une table quelconque
        /***************************************************************/
        public function maj($requeteSQL){

                $reponse = pg_query($this->connexion, $requeteSQL);

                if($reponse == false) {
                    return null;
                }

                return $reponse;
        }
    }	
?>