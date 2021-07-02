<?php
require 'script/session.php';

require 'script/bdd.php';


    //Add Client
    if(!empty($_POST) && isset($_POST['add_client'])) {

        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];


        $dataClient = $bdd->prepare("INSERT INTO `t_client`( `cl_nom`, `cl_adresse`) VALUES (?,?)");
        $dataClient->execute([$nom,$adresse]);
        $dataClient->closeCursor();

        $_SESSION['flash']['success'] = 'Client ajouté avec succès.';

        header('Location: page-clients.php');
        exit();

    }


