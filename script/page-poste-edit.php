<?php
require 'script/session.php';

if(isset($_GET['id'])) {

    require 'script/bdd.php';

    $us_id = $_GET['id'];

    //Poste
    $dataPoste = $bdd->prepare('SELECT * FROM `t_poste_travail`  WHERE pt_id = ? ORDER BY pt_id');
    $dataPoste->execute([$us_id]);
    $poste = $dataPoste->fetch();
    $dataPoste->closeCursor();

    //Machines
    $dataMachines = $bdd->prepare('SELECT * FROM `t_machine`');
    $dataMachines->execute([]);
    $machines = $dataMachines->fetchAll();
    $dataMachines->closeCursor();

    //Liste des Postes UTILISES
    $dataMachinesUtilises = $bdd->prepare('SELECT * FROM `r_machine_poste` rmp JOIN t_machine ma ON ma.ma_id = rmp.ma_id WHERE pt_id = ?');
    $dataMachinesUtilises->execute([$us_id]);
    $machinesUtilises = $dataMachinesUtilises->fetchAll();
    $dataMachinesUtilises->closeCursor();


    //UPDATE DU CLIENT
    if(!empty($_POST) && isset($_POST['edit_poste'])) {
        if($us_id) {

            $libelle = $_POST['pt_libelle'];



            $req = $bdd->prepare("UPDATE `t_poste_travail` SET `pt_libelle`= ? WHERE `pt_id` = ?");
            $req->execute([$libelle,$us_id]);
            $req->closeCursor();

            $reqUser = $bdd->prepare("DELETE FROM `r_machine_poste` WHERE `pt_id` = ?");
            $reqUser->execute([$us_id]);
            $reqUser->closeCursor();

            foreach ($_POST['machine'] as $machine){
                $reqUser = $bdd->prepare("INSERT INTO `r_machine_poste`(`pt_id`, `ma_id`) VALUES (?,?)");
                $reqUser->execute([$us_id,$machine]);
                $reqUser->closeCursor();
            }

            $_SESSION['flash']['success'] = "Poste de travail mis à jour avec succès";

            header('Location: page-poste-edit.php?id='.$us_id);
            exit();
        }
    }

}
