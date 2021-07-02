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

//DELETE Opération
if(!empty($_POST) && isset($_POST['delete_machine'])) {

    $idMachine = $_POST['ma_id'];

    $dataMachinesTrouve = $bdd->prepare('SELECT * FROM `t_operation` WHERE `op_id_machine` = ?');
    $dataMachinesTrouve->execute([$idMachine]);
    $nbMachineUtilise = $dataMachinesTrouve->RowCount();
    $dataMachinesTrouve->closeCursor();


    if ($nbMachineUtilise == 0) {
        $dataDelMachPost = $bdd->prepare("DELETE FROM `r_machine_poste` WHERE `ma_id` = ?");
        $dataDelMachPost->execute([$idMachine]);
        $dataDelMachPost->closeCursor();

        $dataDelMach = $bdd->prepare("DELETE FROM `t_machine` WHERE `ma_id` = ?");
        $dataDelMach->execute([$idMachine]);
        $dataDelMach->closeCursor();

        $_SESSION['flash']['success'] = 'Machine supprimé avec succès.';

        header('Location: page-machine');
        exit();

    } else {
        $_SESSION['flash']['danger'] = 'Impossible de supprimer, cette machine est utilisé';

        header('Location: page-machines');
        exit();

    }
}

    //ADD NEW Machine
    if (!empty($_POST) && isset($_POST['add_machine'])) {

        $reqMachine = $bdd->prepare("INSERT INTO `t_machine`(`ma_libelle`) VALUES (?)");
        $reqMachine->execute([$_POST['libelle_machine']]);
        $reqMachine->closeCursor();

        $lastId = $bdd->lastInsertId();

        foreach ($_POST['poste'] as $poste) {

            $reqMachinePoste = $bdd->prepare("INSERT INTO `r_machine_poste`(`ma_id`, `pt_id`) VALUES (?,?)");
            $reqMachinePoste->execute([$lastId,$poste]);
            $reqMachinePoste->closeCursor();

        }

        $_SESSION['flash']['success'] = "Machines ajouté avec succès";

        header('Location: page-machines');
        exit();

    }
