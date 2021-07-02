<?php
require 'script/session.php';

require 'script/bdd.php';

//Machines
$dataMachines = $bdd->query('SELECT * FROM `t_machine` ORDER BY ma_id');
$dataMachines->execute();
$machines = $dataMachines->fetchAll();
$dataMachines->closeCursor();


$dataPostes = $bdd->query('SELECT * FROM `t_poste_travail`');
$dataPostes->execute();
$postes = $dataPostes->fetchAll();
$dataPostes->closeCursor();

//DELETE Machine
if(!empty($_POST) && isset($_POST['delete_poste'])) {

    $idPoste = $_POST['pt_id'];

    $dataPostesTrouve = $bdd->prepare('SELECT * FROM `t_operation` WHERE `op_id_poste` = ?');
    $dataPostesTrouve->execute([$idPoste]);
    $nbPosteUtilise = $dataPostesTrouve->RowCount();
    $dataPostesTrouve->closeCursor();


    if ($nbPosteUtilise == 0) {
        $dataDelMachPost = $bdd->prepare("DELETE FROM `r_machine_poste` WHERE `pt_id` = ?");
        $dataDelMachPost->execute([$idPoste]);
        $dataDelMachPost->closeCursor();

        $dataDelMach = $bdd->prepare("DELETE FROM `t_poste_travail` WHERE `pt_id` = ?");
        $dataDelMach->execute([$idPoste]);
        $dataDelMach->closeCursor();

        $_SESSION['flash']['success'] = 'Poste de travail supprimé avec succès.';

        header('Location: page-postes');
        exit();

    } else {
        $_SESSION['flash']['danger'] = 'Impossible de supprimer, ce poste de travail est utilisé';

        header('Location: page-postes');
        exit();

    }
}

//ADD NEW POSTE TRAVAIL
if (!empty($_POST) && isset($_POST['add_poste'])) {

    $reqMachine = $bdd->prepare("INSERT INTO `t_poste_travail`(`pt_libelle`) VALUES (?)");
    $reqMachine->execute([$_POST['libelle_poste']]);
    $reqMachine->closeCursor();

    $lastId = $bdd->lastInsertId();

    foreach ($_POST['machine'] as $machine) {

        $reqMachinePoste = $bdd->prepare("INSERT INTO `r_machine_poste`(`ma_id`, `pt_id`) VALUES (?,?)");
        $reqMachinePoste->execute([$machine,$lastId]);
        $reqMachinePoste->closeCursor();

    }

    $_SESSION['flash']['success'] = "Machines ajouté avec succès";

    header('Location: page-postes');
    exit();

}
