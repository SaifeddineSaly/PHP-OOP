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
        
        include("../classes/Utilisateur.php");
        include("../inc/connexion.php");
        $u = new Utilisateur($bdd->get_link());

        if(!$u->get_un($_GET['id']))
            die("Utilisateur n'existe pas");
    
        $msg_nom = $msg_prenom = $msg_mail = $msg_mdp = $msg_ddn = "";
        if(isset($_POST['btnEnvoyer'])){
            if(!$u->set_nom($_POST['txtNom']))
                $msg_nom ="Veuillez entre un nom moins de 50 caracteres";
            if(!$u->set_prenom($_POST['txtPrenom']))
                $msg_prenom ="Veuillez entre un prenom moins de 50 caracteres";
            
            if($u->get_email() != $_POST['txtMail']){
                $r = $u->set_email($_POST['txtMail']);
                if($r == 1)
                    $msg_mail ="Mail deja exist. Veuillez entre un autre mail";
                else if($r == 2)
                    $msg_mail="Veuillez entrer un mail entre 5 et 50 caracteres";
            }
            
            if(!$u->set_mdp($_POST['txtMdp']))
                $msg_mdp ="Mot de passe incorrect (doit etre entre 4 et 15 caracteres). Votre mot de passe est 1234";
            if(!$u->set_ddn($_POST['txtDdn']))
                $msg_ddn ="Date invalide. Votre date de naissance est la date courante";
            
            if($msg_nom == "" && $msg_prenom == "" && $msg_mail == ""){
                if($u->modifier())
                    echo"<script>alert('Utilisateur a ete modifie')</script>";
                else 
                    echo"<script>alert('Utilisateur n a pas ete modifie')</script>";
            }
        }
    ?>
    <h1>Modifiation d'un Utilisateur</h1>
    <form action="" method="post">
        <table>
            <tr>
                <td>Nom*</td>
                <td><input type="text" name="txtNom" value="<?php echo $u->get_nom();?>" required></td>
                <td><?php echo $msg_nom;?></td>
            </tr>
            <tr>
                <td>Prenom*</td>
                <td><input type="text" name="txtPrenom" value="<?php echo $u->get_prenom();?>" required></td>
                <td><?php echo $msg_prenom;?></td>
            </tr>
            <tr>
                <td>Mail*</td>
                <td><input type="email" name="txtMail" value="<?php echo $u->get_email();?>" required></td>
                <td><?php echo $msg_mail;?></td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="txtMdp" value="<?php echo $u->get_mdp();?>"></td>
                <td><?php echo $msg_mdp;?></td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td><input type="date" name="txtDdn" value="<?php echo $u->get_ddn();?>"> aaaa-mm-jj</td>
                <td><?php echo $msg_ddn;?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="btnEnvoyer" value="Envoyer">
                </td>
            </tr>
        </table>
    </form>
    <p align='center'><a href='utilisateur_liste.php'>Retour</a></p
</body>
</html>