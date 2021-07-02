<?php
require 'script/session.php';

require 'script/bdd.php';


//Devis
$dataDevis = $bdd->query('SELECT * FROM t_devis JOIN t_client ON de_id_client = cl_id');
$dataDevis->execute();
$devis = $dataDevis->fetchAll();
$dataDevis->closeCursor();


//Devis
$dataClient = $bdd->query('SELECT * FROM t_client');
$dataClient->execute();
$clients = $dataClient->fetchAll();
$dataClient->closeCursor();


    //ADD DEVIS
    if(!empty($_POST) && isset($_POST['add'])) {

        $client = $_POST['client'];

        $dataAddDevis = $bdd->prepare("INSERT INTO `t_devis`(de_date,de_id_client) VALUES (NOW(),?)");
        $dataAddDevis->execute([$client]);
        $dataAddDevis->closeCursor();


        $lastId = $bdd->lastInsertId();

        $_SESSION['flash']['success'] = 'Devis ajouté';

        header('Location: page-devis-edit.php?id='.$lastId);
        exit();

    }


