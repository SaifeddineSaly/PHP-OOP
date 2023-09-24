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
        if(isset($_GET['id']) == false)
            header("location:utilisateur_liste.php");
        
        /*foreach($_POST as $key => $val)
            echo "<p>$key: $val</p>";*/
        
        include("../classes/Utilisateur.php");
        include("../inc/connexion.php");
        $u = new Utilisateur($bdd->get_link());

        if(!$u->get_un($_GET['id']))
            die("Utilisateur n'existe pas");
        
        if(isset($_POST['btnRetour']))
            header("location:utilisateur_liste.php");
        else if(isset($_POST['btnSupprimer'])){
            if($u->supprimer())
                echo"<script>alert('Utilisateur a ete supprime')</script>";
            else 
                echo"<script>alert('Utilisateur n a pas ete supprime')</script>";
        }
    ?>
    <h1>Suppression d'un utilisateur</h1>
    <form action="" method="post">
        <table>
            <tr>
                <td>Nom</td>
                <td><input type="text" name="txtNom" value="<?php echo $u->get_nom();?>" disabled></td>
            </tr>
            <tr>
                <td>Prenom</td>
                <td><input type="text" name="txtPrenom" value="<?php echo $u->get_prenom();?>" disabled></td>
            </tr>
            <tr>
                <td>Mail</td>
                <td><input type="email" name="txtMail" value="<?php echo $u->get_email();?>" disabled></td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="txtMdp" value="<?php echo $u->get_mdp();?>" readonly></td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td><input type="date" name="txtDdn" value="<?php echo $u->get_ddn();?>" disabled></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="btnSupprimer" value="Supprimer">
                    <input type="submit" name="btnRetour" value="Retour">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>