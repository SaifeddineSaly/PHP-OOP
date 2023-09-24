<?php
    class Utilisateur{
        private $id; // : identifiant unique, auto-increment
        private $nom; // : obligatoire, vc(50), not null
        private $prenom; // : obligatoire, vc(50), not null
        private $ddn; // : non obligatoire, date
        private $email; // : taille entre 5 et 50 caractères, unique, obligatoire, vc(50), not null
        private $mdp; // : taille entre 4 et 15 caractères, la valeur par défaut est ‘1234’
        
        //private $mysql; // :objet de la classe mysql
        private $link; 
        //Les différent setters ( set_nom($s) … ) en prenant en compte les remarques relatives 
        //à chaque attribut
        /*public function set_prenom($prenom){
            $this->prenom = $prenom;
        }
        */
        public function set_prenom($prenom){
            $nb = strlen(trim($prenom));
            if($nb > 0 && $nb <= 50){
                $this->prenom = $prenom;
                return true;
            }
            return false;
        }

        public function set_nom($nom){
            $nb = strlen(trim($nom));
            if($nb > 0 && $nb <= 50){
                $this->nom = $nom;
                return true;
            }
            return false;
        }

        public function set_ddn($ddn){//aaaa-mm-jj
            $a = explode('-', $ddn);
            if(count($a) == 3 && checkdate($a[1], $a[2], $a[0])){
                $this->ddn = $ddn;
                return true;
            }
            $this->ddn = date("Y-m-d"); //valeur par defaut: date courante
            return false;
        }

        public function set_email($email){
            $nb = strlen(trim($email));
            if($nb >=5 && $nb <= 50){
                //verifier si l'email est unique.
                $sql = "select * from Utilisateurs where email='$email'";
                $res = mysqli_query($this->link, $sql);
                if(mysqli_num_rows($res) == 0){
                    $this->email = $email;
                    return 0;
                }
                else 
                    return 1;
            }
            return 2;
        }

        public function set_mdp($mdp){
            $nb = strlen(trim($mdp));
            if($nb >=4 && $nb <= 15){
                $this->mdp = $mdp;
                return true;
            }
            $this->mdp = "1234";
            return false;
        }

        //Les différent getters ( get_nom() …)
        public function get_id(){
            return $this->id;
        }

        public function get_nom(){
            return $this->nom;
        }

        public function get_prenom(){
            return $this->prenom;
        }

        public function get_ddn(){
            return $this->ddn;
        }

        public function get_email(){
            return $this->email;
        }

        public function get_mdp(){
            return $this->mdp;
        }

        //Constructeur() : qui attribue aux attributs les valeurs envoyées par paramètre. 
        public function __construct($link){
            //include("../inc/connexion.php");
            $this->link = $link;//$bdd->get_link();
        }
        
        //enregistrer() : insérer un nouvel enregistrement, enregistrer l’id générer et le retourner.
        /*public function enregistrer($link){
            $sql = "insert into Utilisateurs (Prenom, Nom, email, mot_de_passe, date_de_naissance)
                        values('{$this->prenom}', '{$this->nom}', '{$this->email}', '{$this->mdp}', '{$this->ddn}')";
            mysqli_query($link, $sql);
            if(mysqli_affected_rows($this->link) > 0)
                return true;
            return false;
        }*/

        public function enregistrer(){
            $sql = "insert into Utilisateurs (Prenom, Nom, email, mot_de_passe, date_de_naissance)
                        values('{$this->prenom}', '{$this->nom}', '{$this->email}', '{$this->mdp}', '{$this->ddn}')";
            mysqli_query($this->link, $sql);//$this->mysql->get_link(), $sql);
            if(mysqli_affected_rows($this->link) > 0){
                $this->id = mysqli_insert_id($this->link);
                return true;
            }
            return false;
        }

        //supprimer() : supprimer un enregistrement dont l’identifiant est défini par set_id()
        public function supprimer(){
            $sql = "delete from Utilisateurs where id = {$this->id}";
            mysqli_query($this->link, $sql);
            if(mysqli_affected_rows($this->link) > 0)
                return true;
            return false;
        }

        //modifier() : mettre à jour un enregistrement existant
        public function modifier(){
            $sql = "update Utilisateurs set prenom ='{$this->prenom}',
                            nom='{$this->nom}', date_de_naissance='{$this->ddn}',
                            mot_de_passe='{$this->mdp}', email='{$this->email}'
                            where id = {$this->id}";
            mysqli_query($this->link, $sql);
            if(mysqli_affected_rows($this->link) > 0)
                return true;
            return false;
        }

        //get_un($id) : envoi un objet rempli avec les données de l’utilisateur dont l’id est passé en paramètre.
        public function get_un($id){
            $sql = "select * from Utilisateurs where id = $id";
            $res = mysqli_query($this->link, $sql);
            if(mysqli_num_rows($res) == 1){
                $row = mysqli_fetch_array($res);
                $this->id = $id; // =$row['id']
                $this->set_nom($row['nom']);
                $this->set_prenom($row['prenom']);
                $this->email = $row['email']; //set_email($row['email']);
                $this->ddn = $row['date_de_naissance'];
                $this->mdp = $row['mot_de_passe'];
                return true;
            }
            return false; //id n'existe pas dans la table
        }

        //get_liste($order_by=’id’, $order_type=’ASC’) : renvoi le contenu de la table sous forme de 
        //tableau d’objets. Si le 1er paramètre est spécifié, le tri se fait sur le nom de la colonne 
        //défini, sinon le tri se fait sur l’id. Le tri se fait selon le 2ème paramètre : ASCendant 
        //(par défaut) ou DESCendant.
        public function get_list($order_by='id', $order_type='asc'){
            $sql="select * from Utilisateurs order by $order_by $order_type";
            $res = mysqli_query($this->link, $sql);
            $a = array();
            while($row = mysqli_fetch_object($res)){
                $a[] = $row;
            }
            /*while($row = mysqli_fetch_array($res)){
                $u = new stdClass();
                $u->id = $row['id'];
                $u->prenom = $row['prenom'];
                $u->nom = $row['nom'];
                $u->email = $row['email'];
                $u->mot_de_passe = $row['mot_de_passe'];
                $u->date_de_naissance = $row['date_de_naissance'];

                $a[] = $u;
            }*/
            return $a;
        }

    }
?>