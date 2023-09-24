<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $order_by="id";
        $order_type="asc";
        if(isset($_POST['btnAfficher'])){
            $order_by = $_POST['cmbAttribut'];
            $order_type = $_POST['rbOrder'];
        }
    ?>
    <p align='right'><a href='utilisateur_ajout.php'>Nouvel Utilisateur</a></p>
    <center>
    <form action="" method="post">
        <p>
            Ordonner les utilisateurs selon: 
            <select name="cmbAttribut" id="">
                <?php
                    $a = array("id"=>"ID", "prenom" => "Prenom", "nom"=>"Nom",
                                "email"=>"Email", "mot_de_passe"=>"Mot de passe",
                                "date_de_naissance"=>"Date de naissance");
                    foreach($a as $key=> $val){
                        if($order_by == $key)
                            $s = "selected";
                        else 
                            $s="";
                        echo "<option value='$key' $s>$val</option>";
                    }
                ?>
            </select>
            <br>
            en order 
            <input type="radio" name="rbOrder" id="rbAsc" value="asc" 
                    <?php if($order_type=="asc") echo "checked";?>>
            <label for="rbAsc">Croissant</label>
            <input type="radio" name="rbOrder" id="rbDesc" value="desc"
                    <?php if($order_type=="desc") echo "checked";?>>
            <label for="rbDesc">Decroissant</label>
            <br>
            <input type="submit" value="Afficher" name="btnAfficher">
        </p>
    </form>
    </center>
    
    <table border="1" align="center">
        <tr>
            <th>ID</th>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Mot de passe</th>
            <th>Date de naissance</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
            include("../classes/Utilisateur.php");
            include("../inc/connexion.php");
            $u = new Utilisateur($bdd->get_link());
            $a = $u->get_list($order_by, $order_type);
            foreach($a as $val){
                echo"<tr><td>{$val->id}</td><td>{$val->prenom}</td><td>{$val->nom}</td>
                            <td>{$val->email}</td><td>{$val->mot_de_passe}</td>
                            <td>{$val->date_de_naissance}</td>
                            <td><a href='utilisateur_modification.php?id={$val->id}'>Modifier</a></td>
                            <td><a href='utilisateur_suppression.php?id={$val->id}'>Supprimer</a></td>
                    </tr>";
            }
        ?>
    </table>
</body>
</html>