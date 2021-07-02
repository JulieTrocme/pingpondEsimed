<?php
require 'script/session.php';

require 'script/bdd.php';


if(isset($_GET['id'])) {

    $id = $_GET['id'];

    //Operation
    $dataGamme = $bdd->prepare('SELECT * FROM t_gamme JOIN t_ouvrier ON ga_id_responsable = ou_id JOIN t_piece ON pi_id = ga_id_piece WHERE ga_id = ?');
    $dataGamme->execute([$id]);
    $gamme = $dataGamme->fetch();
    $dataGamme->closeCursor();

    //GAMMES
    $dataGammes = $bdd->prepare('SELECT * FROM `t_gamme`');
    $dataGammes->execute();
    $gammes = $dataGammes->fetchAll();
    $dataGammes->closeCursor();

    //Qualification de l'ouvrier
    $dataQualifs = $bdd->prepare('SELECT * FROM `t_ouvrier` JOIN r_qualification ON ou_id = qu_id_ouvrier WHERE ou_id = ?');
    $dataQualifs->execute([$gamme['ou_id']]);
    $qualifs = $dataQualifs->fetchAll();
    $dataQualifs->closeCursor();



    $operations = [];
    $nbOperations = 0;

   foreach ($qualifs as $qualif){
        //Operation
        $dataOperation = $bdd->prepare('SELECT * FROM t_operation WHERE op_id_poste = ?');
        $dataOperation->execute([$qualif['qu_id_poste_travail']]);
        $operations = array_merge($operations,$dataOperation->fetchAll());
        $nbOperations += $dataOperation->RowCount();
        $dataOperation->closeCursor();
    }


    //Machines
    $dataMachines = $bdd->query('SELECT * FROM t_machine');
    $dataMachines->execute();
    $machines = $dataMachines->fetchAll();
    $dataMachines->closeCursor();


    //Responsables
    $dataResponsables = $bdd->query('SELECT * FROM t_ouvrier');
    $dataResponsables->execute();
    $responsables = $dataResponsables->fetchAll();
    $dataResponsables->closeCursor();


    //PIECES
    $dataPieces = $bdd->prepare('SELECT * FROM `t_piece` WHERE pi_id_type != 1');
    $dataPieces->execute();
    $pieces = $dataPieces->fetchAll();
    $dataPieces->closeCursor();


    //Poste
    $dataPoste = $bdd->query('SELECT * FROM t_poste_travail');
    $dataPoste->execute();
    $postes = $dataPoste->fetchAll();
    $dataPoste->closeCursor();

    //PIECE
    $dataPiece = $bdd->prepare('SELECT * FROM t_gamme JOIN t_ouvrier ON ga_id_responsable = ou_id JOIN t_piece ON pi_id = ga_id_piece WHERE ga_id = ?');
    $dataPiece->execute([$id]);
    $piece = $dataPiece->fetch();
    $dataPiece->closeCursor();


    //Operation UTILISE
    $dataOperationUtilises = $bdd->prepare('SELECT * FROM t_operation op JOIN t_machine ON ma_id = op_id_machine JOIN t_poste_travail ON pt_id = op_id_poste JOIN r_gamme_operation gop ON gop.op_id = op.op_id WHERE gop.ga_id = ?');
    $dataOperationUtilises->execute([$id]);
    $operationUtilises = $dataOperationUtilises->fetchAll();
    $dataOperationUtilises->closeCursor();

    //Edit GAMME
    if(!empty($_POST) && isset($_POST['edit_gamme'])) {

        $libelle = $_POST['ga_libelle'];
        $resp = $_POST['ga_id_responsable'];
        $pie = $_POST['ga_id_piece'];


        $dataEditGamme = $bdd->prepare("UPDATE `t_gamme` SET `ga_id_responsable`= ?,`ga_id_piece`= ?,`ga_libelle`= ? WHERE `ga_id` = ?");
        $dataEditGamme->execute([$resp,$pie,$libelle,$id]);
        $dataEditGamme->closeCursor();

        $_SESSION['flash']['success'] = 'Gamme modifier avec succès.';

        header('Location: page-gamme-edit.php?id='.$id);
        exit();

    }

    //ADD NEW OPERATION
    if(!empty($_POST) && isset($_POST['add_new_operation'])) {

        $libelle = $_POST['op_libelle'];
        $tempsRea = $_POST['op_temps'];
        $machine = $_POST['op_machine'];
        $poste = $_POST['op_poste'];


        $dataAddOperation = $bdd->prepare("INSERT INTO `t_operation`(`op_id_machine`, `op_id_poste`, `op_temps_realisation`, `op_libelle`) VALUES (?,?,?,?)");
        $dataAddOperation->execute([$machine,$poste,$tempsRea,$libelle]);
        $dataAddOperation->closeCursor();

        $lastId = $bdd->lastInsertId();

        $dataGammeOp = $bdd->prepare("INSERT INTO `r_gamme_operation`(`ga_id`, `op_id`) VALUES (?,?)");
        $dataGammeOp->execute([$id,$lastId]);
        $dataGammeOp->closeCursor();

        $_SESSION['flash']['success'] = 'Opération ajouté avec succès.';

        header('Location: page-gamme-edit.php?id='.$id);
        exit();

    }


    //ADD NEW OPERATION
    if(!empty($_POST) && isset($_POST['add_operation'])) {

        $reqGammeOp = $bdd->prepare("DELETE FROM `r_gamme_operation` WHERE `ga_id` = ?");
        $reqGammeOp->execute([$id]);
        $reqGammeOp->closeCursor();

        foreach ($_POST['operation'] as $op) {

            $reqMdp = $bdd->prepare("INSERT INTO `r_gamme_operation`(`ga_id`, `op_id`) VALUES (?,?)");
            $reqMdp->execute([$id,$op]);
            $reqMdp->closeCursor();


        }

        $_SESSION['flash']['success'] = "Opération de cette gamme mis à jour avec succès";

        header('Location: page-gamme-edit.php?id='.$id);
        exit();

    }


    //UPDATE Operation
    if(!empty($_POST) && isset($_POST['update_operation'])) {

        $idOperation =  $_POST['id_op'];
        $libelle = $_POST['op_libelle'];
        $tempsRea = $_POST['op_temps'];
        $machine = $_POST['op_machine'];
        $poste = $_POST['op_poste'];

        $dataUpdateOp = $bdd->prepare("UPDATE `t_operation` SET `op_id_machine`= ?,`op_id_poste`= ?,`op_temps_realisation`= ?,`op_libelle`= ? WHERE `op_id` = ?");
        $dataUpdateOp->execute([$machine,$poste,$tempsRea,$libelle,$idOperation]);
        $dataUpdateOp->closeCursor();


        $_SESSION['flash']['success'] = 'Opération modifié avec succès.';
        header('Location: page-gamme-edit.php?id='.$id);
        exit();



    }

    //DELETE Opération
    if(!empty($_POST) && isset($_POST['delete_operation'])) {

        $idOperation = $_POST['op_id'];

        $dataDelOp = $bdd->prepare("DELETE FROM r_gamme_operation WHERE op_id = ?");
        $dataDelOp->execute([$idOperation]);
        $dataDelOp->closeCursor();


        $_SESSION['flash']['success'] = 'Opération dans cette gamme supprimé avec succès.';

        header('Location: page-gamme-edit.php?id='.$id);
        exit();

    }

}