<?php
    include("../classes/mysql.php");
    $bdd = new Mysql();
    $bdd->set_serveur("localhost");
    $bdd->set_login("root");
    $bdd->set_mdp("");
    $bdd->set_bdd("integration1920");
    $bdd->connexion();

    /*
    //meme exercice, mais utilise le constructeur
    //constructeur 1:
    $bdd = new Mysql("localhost", "root", "", "integration1920");
    //constructeur 2:
    $bdd = new Mysql("integration1920");
    //$bdd->set_mdp("123");
    //constucteur 3:
    $bdd = new Mysql();
    */
?>
