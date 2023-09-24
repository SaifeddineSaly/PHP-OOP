<?php
    class Mysql{
        private $serveur = "localhost"; // (host) : définir « locahost » comme valeur par défaut
        private $login;
        private $mdp; // : mot de passe
        private $bdd; // : nom de la base de donnees
        private $link; // (identifiant de connexion) : la valeur retourné par mysqli_connect()

        //setter
        public function set_serveur($serveur){
            $this->serveur = $serveur;
        }

        public function set_login($login){
            $this->login = $login;
        }

        public function set_mdp($mdp){
            $this->mdp = $mdp;
        }

        public function set_bdd($bdd){
            $this->bdd = $bdd;
        }

        //connexion(): permet de se connecter à la bdd et d’affecter l’identifiant de la 
            //connexion à l’attribut privé $link.
        public function connexion(){
            $this->link = mysqli_connect($this->serveur, $this->login, $this->mdp, $this->bdd)
                        or die("Impossible de se connecter au serveur MySQL");
        }

        //get_link() : renvoi la valeur de l’identifiant de connexion.
        public function get_link(){
            return $this->link;
        }

        //deconnexion() : permet de fermer la connexion à la base de données.
        public function deconnexion(){
            if($this->link != false)
                mysqli_close($this->link);
        }

        //requete($q) : permet d’exécuter une requête $q et de renvoyer son résultat.
        public function requete($sql){
            $res = mysqli_query($this->link, $sql)
                or die("Requete est incorrecte: '$sql'");
            return $res;
        }
        
        /*
        //Constructeur(): qui attribue aux attributs serveur, login, mdp, bdd les valeurs envoyées 
                //par paramètre. Ainsi, cette méthode permet de se connecter au serveur MySQL et de 
                //sélectionner la base de données.
        public function __construct($serveur, $login, $mdp, $bdd){
            $this->set_serveur($serveur); //$this->serveur = $serveur;
            $this->set_login($login);
            $this->set_mdp($mdp);
            $this->set_bdd($bdd);

            //connecter au serveur MySQL et de sélectionner la base de données.
            $this->link = mysqli_connect($this->serveur, $this->login, $this->mdp, $this->bdd)
                    or die("Impossible de se connecter au serveur MySQL");
        }

        public function __construct($bdd){
            $this->set_serveur("localhost"); //$this->serveur = $serveur;
            $this->set_login("root");
            $this->set_mdp("");
            $this->set_bdd($bdd);

            //connecter au serveur MySQL et de sélectionner la base de données.
            $this->link = mysqli_connect($this->serveur, $this->login, $this->mdp, $this->bdd)
                    or die("Impossible de se connecter au serveur MySQL");
        }

        public function __construct(){
            $this->set_serveur("localhost"); //$this->serveur = $serveur;
            $this->set_login("root");
            $this->set_mdp("");
            $this->set_bdd("integration1920");

            //connecter au serveur MySQL et de sélectionner la base de données.
            $this->link = mysqli_connect($this->serveur, $this->login, $this->mdp, $this->bdd)
                    or die("Impossible de se connecter au serveur MySQL");
        }
        */
    }
?>