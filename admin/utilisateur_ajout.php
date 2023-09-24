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
        $nom = $prenom = $mail = $mdp = $ddn = "";
        $msg_nom = $msg_prenom = $msg_mail = $msg_mdp = $msg_ddn = "";

        if(isset($_POST['btnEnvoyer'])){
            $nom = $_POST['txtNom'];
            $prenom = $_POST['txtPrenom'];
            $mail = $_POST['txtMail'];
            $ddn = $_POST['txtDdn'];
            $mdp = $_POST['txtMdp'];

            include("../classes/Utilisateur.php");
            include("../inc/connexion.php");
            $u = new Utilisateur($bdd->get_link()); //$bdd est un object de la classe MySQL defini dans connexion.php
            if(!$u->set_nom($_POST['txtNom']))
                $msg_nom ="Veuillez entre un nom moins de 50 caracteres";
            if(!$u->set_prenom($_POST['txtPrenom']))
                $msg_prenom ="Veuillez entre un prenom moins de 50 caracteres";
            $r = $u->set_email($_POST['txtMail']);
            if($r == 1)
                $msg_mail ="Mail deja exist. Veuillez entre un autre mail";
            else if($r == 2)
                $msg_mail="Veuillez entrer un mail entre 5 et 50 caracteres";
            if(!$u->set_mdp($_POST['txtMdp']))
                $msg_mdp ="Mot de passe incorrect (doit etre entre 4 et 15 caracteres). Votre mot de passe est 1234";
            if(!$u->set_ddn($_POST['txtDdn']))
                $msg_ddn ="Date invalide. Votre date de naissance est la date courante";
            
            if($msg_nom == "" && $msg_prenom == "" && $msg_mail == ""){
                if($u->enregistrer())
                    echo"<script>alert('Utilisateur a ete ajoute et son id est {$u->get_id()}.')</script>";
                else 
                    echo"<script>alert('Utilisateur n'a pas ete ajoute')</script>";
            }
        }
    ?>
    <h1>Nouvel Utilisateur</h1>
    <form action="" method="post">
        <table>
            <tr>
                <td>Nom*</td>
                <td><input type="text" name="txtNom" value="<?php echo $nom;?>" required></td>
                <td><?php echo $msg_nom;?></td>
            </tr>
            <tr>
                <td>Prenom*</td>
                <td><input type="text" name="txtPrenom" value="<?php echo $prenom;?>" required></td>
                <td><?php echo $msg_prenom;?></td>
            </tr>
            <tr>
                <td>Mail*</td>
                <td><input type="email" name="txtMail" value="<?php echo $mail;?>" required></td>
                <td><?php echo $msg_mail;?></td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="txtMdp" value="<?php echo $mdp;?>"></td>
                <td><?php echo $msg_mdp;?></td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td><input type="date" name="txtDdn" value="<?php echo $ddn;?>"> aaaa-mm-jj</td>
                <td><?php echo $msg_ddn;?></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="btnEnvoyer" value="Envoyer"></td>
            </tr>
        </table>
    </form>
    <p align='center'><a href='utilisateur_liste.php'>Retour</a></p>
</body>
</html>