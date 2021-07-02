<?php
require 'script/session.php';

require 'script/bdd.php';


if(isset($_GET['id'])) {

    $id = $_GET['id'];


    //Devis
    $dataClient = $bdd->prepare('SELECT * FROM t_client WHERE cl_id = ?');
    $dataClient->execute([$id]);
    $client = $dataClient->fetch();
    $dataClient->closeCursor();

    //Edit GAMME
    if(!empty($_POST) && isset($_POST['edit_client'])) {

        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];


        $dataClient = $bdd->prepare("UPDATE `t_client` SET `cl_nom`= ?,`cl_adresse`= ? WHERE `cl_id` = ?");
        $dataClient->execute([$nom,$adresse,$id]);
        $dataClient->closeCursor();

        $_SESSION['flash']['success'] = 'Client modifié avec succès.';

        header('Location: page-client-edit.php?id='.$id);
        exit();

    }

}
