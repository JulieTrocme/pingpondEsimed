<?php
require 'script/session.php';

require 'script/bdd.php';


if(isset($_GET['id'])) {

    $id = $_GET['id'];
    $date = $_GET['date'];

    $dataGamme = $bdd->prepare('SELECT * FROM t_gamme JOIN t_ouvrier ON ou_id = ga_id_responsable WHERE ga_id = ?');
    $dataGamme->execute([$id]);
    $gamme = $dataGamme->fetch();
    $dataGamme->closeCursor();

    $dataOuvrier = $bdd->prepare('SELECT * FROM t_ouvrier');
    $dataOuvrier->execute([]);
    $ouvriers = $dataOuvrier->fetchAll();
    $dataOuvrier->closeCursor();

    //Realisations
    $dataRealisations = $bdd->prepare('SELECT * FROM t_realisation re JOIN r_gamme_realisation gre ON re.re_id = gre.re_id JOIN t_machine ma ON ma.ma_id=re.re_id_machine JOIN t_poste_travail pt ON pt.pt_id= re.re_id_poste LEFT JOIN t_ouvrier ou ON ou.ou_id = re.re_id_ouvrier WHERE gre.ga_id = ?AND re.re_date_effectue = ?');
    $dataRealisations->execute([$id,$date]);
    $realisations = $dataRealisations->fetchAll();
    $dataRealisations->closeCursor();

    //Machines
    $dataMachines = $bdd->query('SELECT * FROM t_machine');
    $dataMachines->execute();
    $machines = $dataMachines->fetchAll();
    $dataMachines->closeCursor();

    //UPDATE Operation
    if(!empty($_POST) && isset($_POST['update_realisation'])) {

        $idRea =  $_POST['re_id'];
        $temps = $_POST['re_temps'];
        $machine = $_POST['re_machine'];
        $poste = $_POST['re_poste'];
        $ouvrier = $_POST['re_ouvrier'];

        $dataUpdateOp = $bdd->prepare("UPDATE `t_realisation` SET `re_id_machine`= ?,`re_id_poste`= ?,`re_temps_realisation`= ?, re_id_ouvrier = ? WHERE `re_id` = ?");
        $dataUpdateOp->execute([$machine,$poste,$temps,$ouvrier,$idRea]);
        $dataUpdateOp->closeCursor();


        $_SESSION['flash']['success'] = 'Réalisation modifié avec succès.';
        header('Location: page-realisation-edit.php?id='.$id.'&date='.$date);
        exit();



    }


}