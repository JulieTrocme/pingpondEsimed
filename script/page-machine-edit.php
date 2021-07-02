<?php
require 'script/session.php';

if(isset($_GET['id'])) {

    require 'script/bdd.php';

    $us_id = $_GET['id'];

    //Machine
    $dataMachine = $bdd->prepare('SELECT * FROM `t_machine` WHERE ma_id = ?');
    $dataMachine->execute([$us_id]);
    $machine = $dataMachine->fetch();
    $dataMachine->closeCursor();

    //Liste des Postes
    $dataPostes = $bdd->query('SELECT * FROM `t_poste_travail` ORDER BY pt_id');
    $dataPostes->execute();
    $postes = $dataPostes->fetchAll();
    $dataPostes->closeCursor();

    //Liste des Postes UTILISES
    $dataPostesUtilises = $bdd->prepare('SELECT * FROM `r_machine_poste` rmp JOIN t_poste_travail pt ON pt.pt_id = rmp.pt_id WHERE ma_id = ?');
    $dataPostesUtilises->execute([$us_id]);
    $postesUtilises = $dataPostesUtilises->fetchAll();
    $dataPostesUtilises->closeCursor();


    //UPDATE DU CLIENT
    if(!empty($_POST) && isset($_POST['edit_machine'])) {
        if($us_id) {

            $libelle = $_POST['ma_libelle'];



            $req = $bdd->prepare("UPDATE `t_machine` SET `ma_libelle`= ? WHERE `ma_id` = ?");
            $req->execute([$libelle,$us_id]);
            $req->closeCursor();

            $reqUser = $bdd->prepare("DELETE FROM `r_machine_poste` WHERE `ma_id` = ?");
            $reqUser->execute([$us_id]);
            $reqUser->closeCursor();

            foreach ($_POST['poste'] as $poste){
                $reqUser = $bdd->prepare("INSERT INTO `r_machine_poste`(`pt_id`, `ma_id`) VALUES (?,?)");
                $reqUser->execute([$poste,$us_id]);
                $reqUser->closeCursor();
            }

            $_SESSION['flash']['success'] = "Machine mis à jour avec succès";

            header('Location: page-machine-edit.php?id='.$us_id);
            exit();
        }
    }

}
