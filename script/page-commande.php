<?php
	require 'script/session.php';
	
	require 'script/bdd.php';




//Commandes CLient
$dataCommandeClients = $bdd->query('SELECT * FROM `t_commande` JOIN t_client ON cl_id = co_id_client WHERE co_id_type = 1');
$dataCommandeClients->execute();
$commandeClients = $dataCommandeClients->fetchAll();
$dataCommandeClients->closeCursor();


//Commandes d'achat
$dataCommandeAchats = $bdd->query('SELECT * FROM `t_commande`WHERE co_id_type = 2');
$dataCommandeAchats->execute();
$commandeAchats = $dataCommandeAchats->fetchAll();
$dataCommandeAchats->closeCursor();


//Devis
$dataClient = $bdd->query('SELECT * FROM t_client');
$dataClient->execute();
$clients = $dataClient->fetchAll();
$dataClient->closeCursor();


//ADD Commande client
if(!empty($_POST) && isset($_POST['add'])) {

    $client = $_POST['client'];

    $dataAddDevis = $bdd->prepare("INSERT INTO `t_commande`(`co_id_type`, `co_id_client`, `co_date`, `co_statut`) VALUES (?,?,NOW(),?)");
    $dataAddDevis->execute([1,$client,0]);
    $dataAddDevis->closeCursor();


    $lastId = $bdd->lastInsertId();

    $_SESSION['flash']['success'] = 'Commande client ajouté';

    header('Location: page-commande-client-edit.php?id='.$lastId);
    exit();

}