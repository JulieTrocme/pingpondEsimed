<?php
require 'script/session.php';

require 'script/bdd.php';


if(isset($_GET['id'])) {

    $id = $_GET['id'];


    //client
    $dataClient = $bdd->query('SELECT * FROM t_client');
    $dataClient->execute();
    $clients = $dataClient->fetchAll();
    $dataClient->closeCursor();


    //Pieces
    $dataPieces = $bdd->query('SELECT * FROM t_piece WHERE pi_id_type !=1');
    $dataPieces->execute();
    $pieces = $dataPieces->fetchAll();
    $dataPieces->closeCursor();

    //Devis
    $datadevis = $bdd->prepare('SELECT * FROM t_devis WHERE de_id = ?');
    $datadevis->execute([$id]);
    $devis = $datadevis->fetch();
    $datadevis->closeCursor();

    //Ligne Devis
    $dataLigneDevis = $bdd->prepare('SELECT * FROM t_ligne_devis JOIN t_piece ON ld_id_art = pi_id WHERE ld_id_devis = ?');
    $dataLigneDevis->execute([$id]);
    $ligneDevis = $dataLigneDevis->fetchAll();
    $dataLigneDevis->closeCursor();


    //UPDATE info devis
    if(!empty($_POST) && isset($_POST['edit_devis'])) {

        $client = $_POST['client'];
        $dateDelais = $_POST['dateDelais'];

        if ($dateDelais == ''){
            $dateDelais = null;
        } else {
            $dateDelais =  date('Y-m-d', strtotime(str_replace('/','-', $dateDelais)));
        }

        $dataUpdatePieceUtil = $bdd->prepare('UPDATE t_devis SET de_id_client = ?, de_date_delais = ? WHERE `de_id` = ?');
        $dataUpdatePieceUtil->execute([$client,$dateDelais,$id]);
        $dataUpdatePieceUtil->closeCursor();

        $_SESSION['flash']['success'] = 'Information du devis modifié avec succès.';
        header('Location: page-devis-edit.php?id='.$id);
        exit();
    }


    //UPDATE QTE PIECE
    if(!empty($_POST) && isset($_POST['update_qte'])) {

        $idLigne =  $_POST['id_pu'];
        $qte = $_POST['pu_qte'];


        if ($_POST['pu_qte'] != "" && $_POST['id_pu'] != "") {


            $dataUpdatePieceUtil = $bdd->prepare("UPDATE `t_ligne_devis` SET `ld_qte`= ? WHERE `ld_id` = ?");
            $dataUpdatePieceUtil->execute([$qte,$idLigne]);
            $dataUpdatePieceUtil->closeCursor();


            //Ligne Devis
            $dataNewLigneDevis = $bdd->prepare('SELECT * FROM t_ligne_devis WHERE ld_id_devis = ?');
            $dataNewLigneDevis->execute([$id]);
            $newLigneDevis = $dataNewLigneDevis->fetchAll();
            $dataNewLigneDevis->closeCursor();

            $newMtn = 0;
            foreach ($newLigneDevis as $ld){
                $newMtn += ($ld['ld_qte']*$ld['ld_mtn']);
            }

            //On modifie le montant du devis
            $dataUpdateDevisMtn = $bdd->prepare("UPDATE `t_devis` SET `de_mtn`= ? WHERE `de_id` = ?");
            $dataUpdateDevisMtn->execute([$newMtn,$id]);
            $dataUpdateDevisMtn->closeCursor();



            $_SESSION['flash']['success'] = 'Quantité pour cette pièce modifié avec succès.';
            header('Location: page-devis-edit.php?id='.$id);
            exit();
        }


    }

    //DELETE Prix
    if(!empty($_POST) && isset($_POST['delete_piece'])) {
        $idLigne = $_POST['pu_id'];

        $dataDltUniteProd = $bdd->prepare("DELETE FROM t_ligne_devis WHERE ld_id = ?");
        $dataDltUniteProd->execute([$idLigne]);
        $dataDltUniteProd->closeCursor();


        //Ligne Devis
        $dataNewLigneDevis = $bdd->prepare('SELECT * FROM t_ligne_devis WHERE ld_id_devis = ?');
        $dataNewLigneDevis->execute([$id]);
        $newLigneDevis = $dataNewLigneDevis->fetchAll();
        $dataNewLigneDevis->closeCursor();

        $newMtn = 0;
        foreach ($newLigneDevis as $ld){
            $newMtn += ($ld['ld_qte']*$ld['ld_mtn']);
        }

        //On modifie le montant du devis
        $dataUpdateDevisMtn = $bdd->prepare("UPDATE `t_devis` SET `de_mtn`= ? WHERE `de_id` = ?");
        $dataUpdateDevisMtn->execute([$newMtn,$id]);
        $dataUpdateDevisMtn->closeCursor();



        $_SESSION['flash']['success'] = 'Piece supprimé avec succès.';

        header('Location: page-devis-edit.php?id='.$id);
        exit();

    }

    //Add PIECE devis
    if(!empty($_POST) && isset($_POST['add_piece_devis'])) {


        foreach ($_POST['pieces'] as $piece){

            //On cherche le detail de la piece select
            $dataPieceSelect = $bdd->prepare('SELECT * FROM t_piece WHERE pi_id = ?');
            $dataPieceSelect->execute([$piece]);
            $pieceSelect = $dataPieceSelect->fetch();
            $dataPieceSelect->closeCursor();

            //ON regarde si la pièce existe déjà dans les lignes du devis
            $dataPieceExiste = $bdd->prepare('SELECT * FROM t_ligne_devis WHERE ld_id_devis = ? AND ld_id_art = ?');
            $dataPieceExiste->execute([$id,$piece]);
            $existe = $dataPieceExiste->fetch();
            $nbExiste = $dataPieceExiste->RowCount();
            $dataPieceExiste->closeCursor();

            if ($nbExiste > 0){

                $newQte = $existe['ld_qte'] + 1;

                //On l'augmente
                $dataUpdatePieceUtil = $bdd->prepare("UPDATE `t_ligne_devis` SET `ld_qte`= ? WHERE `ld_id` = ?");
                $dataUpdatePieceUtil->execute([$newQte,$existe['ld_id']]);
                $dataUpdatePieceUtil->closeCursor();

            }else {

                $newQte = 1;
                //INSERT PIECE DANS DEVIS
                $dataInsDevis = $bdd->prepare("INSERT INTO `t_ligne_devis`(`ld_id_devis`, `ld_id_art`, `ld_qte`, `ld_mtn`) VALUES (?,?,?,?)");
                $dataInsDevis->execute([$id,$piece,$newQte,$pieceSelect['pi_prix']]);
                $dataInsDevis->closeCursor();
            }
        }




        //Ligne Devis
        $dataNewLigneDevis = $bdd->prepare('SELECT * FROM t_ligne_devis WHERE ld_id_devis = ?');
        $dataNewLigneDevis->execute([$id]);
        $newLigneDevis = $dataNewLigneDevis->fetchAll();
        $dataNewLigneDevis->closeCursor();

        $newMtn = 0;
        foreach ($newLigneDevis as $ld){
            $newMtn += ($ld['ld_qte']*$ld['ld_mtn']);
        }

        //On modifie le montant du devis
        $dataUpdateDevisMtn = $bdd->prepare("UPDATE `t_devis` SET `de_mtn`= ? WHERE `de_id` = ?");
        $dataUpdateDevisMtn->execute([$newMtn,$id]);
        $dataUpdateDevisMtn->closeCursor();

        $_SESSION['flash']['success'] = 'Pièces ajouté dans le devis avec succès.';
        header('Location: page-devis-edit.php?id='.$id);
        exit();



    }


}


