<?php
require 'script/session.php';

require 'script/bdd.php';


if(isset($_GET['id'])) {

    $id = $_GET['id'];


    //Commande
    $dataCommande = $bdd->prepare('SELECT * FROM t_commande WHERE co_id = ?');
    $dataCommande->execute([$id]);
    $commande = $dataCommande->fetch();
    $dataCommande->closeCursor();

    //Pieces
    $dataPieces = $bdd->query('SELECT * FROM t_piece WHERE pi_id_type = 1');
    $dataPieces->execute();
    $pieces = $dataPieces->fetchAll();
    $dataPieces->closeCursor();


    //Ligne commande
    $dataLignecommande = $bdd->prepare('SELECT * FROM t_ligne_commande JOIN t_piece ON pi_id = lc_id_art WHERE lc_id_commande = ?');
    $dataLignecommande->execute([$id]);
    $lignecommande = $dataLignecommande->fetchAll();
    $dataLignecommande->closeCursor();

    //UPDATE info commande
    if(!empty($_POST) && isset($_POST['edit_commande'])) {


        $datePrevue = $_POST['datePrevue'];
        $dateReelle = $_POST['dateReelle'];

        if ($datePrevue == ''){
            $datePrevue = null;
        } else {
            $datePrevue =  date('Y-m-d', strtotime(str_replace('/','-', $datePrevue)));
        }

        if ($dateReelle == ''){
            $dateReelle = null;
        } else {
            $dateReelle =  date('Y-m-d', strtotime(str_replace('/','-', $dateReelle)));
        }


        $dataUpdatePieceUtil = $bdd->prepare('UPDATE `t_commande` SET `co_date_livraison_prevu`= ?,`co_date_livraison_reelle`= ? WHERE `co_id` = ?');
        $dataUpdatePieceUtil->execute([$datePrevue,$dateReelle,$id]);
        $dataUpdatePieceUtil->closeCursor();

        $_SESSION['flash']['success'] = 'Information de la commande modifié avec succès.';
        header('Location: page-commande-achat-edit.php?id='.$id);
        exit();
    }

    //DELETE PIECE
    if(!empty($_POST) && isset($_POST['delete_piece'])) {
        $idLigne = $_POST['pu_id'];


        //On delete la ligne de commande
        $dataDltUniteProd = $bdd->prepare("DELETE FROM t_ligne_commande WHERE lc_id = ?");
        $dataDltUniteProd->execute([$idLigne]);
        $dataDltUniteProd->closeCursor();

        //Lignes de commande
        $dataNewLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ?');
        $dataNewLigneCommande->execute([$id]);
        $newLigneCommande = $dataNewLigneCommande->fetchAll();
        $dataNewLigneCommande->closeCursor();

        $newMtn = 0;
        foreach ($newLigneCommande as $lc){
            $newMtn += ($lc['lc_qte']*$lc['lc_mtn']);
        }

        //On modifie le montant de la commande
        $dataUpdateCommandeMtn = $bdd->prepare("UPDATE `t_commande` SET `co_mtn`= ? WHERE `co_id` = ?");
        $dataUpdateCommandeMtn->execute([$newMtn,$id]);
        $dataUpdateCommandeMtn->closeCursor();

        $_SESSION['flash']['success'] = 'Piece supprimé avec succès.';
        header('Location: page-commande-achat-edit.php?id='.$id);
        exit();

    }

    //UPDATE QTE PIECE
    if(!empty($_POST) && isset($_POST['update_qte'])) {

        $idLigne =  $_POST['id_pu'];
        $qte = $_POST['pu_qte'];


        if ($_POST['pu_qte'] != "" && $_POST['id_pu'] != "") {


            $dataUpdatePieceUtil = $bdd->prepare("UPDATE `t_ligne_commande` SET `lc_qte`= ? WHERE `lc_id` = ?");
            $dataUpdatePieceUtil->execute([$qte,$idLigne]);
            $dataUpdatePieceUtil->closeCursor();


            //Lignes de commande
            $dataNewLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ?');
            $dataNewLigneCommande->execute([$id]);
            $newLigneCommande = $dataNewLigneCommande->fetchAll();
            $dataNewLigneCommande->closeCursor();

            $newMtn = 0;
            foreach ($newLigneCommande as $lc){
                $newMtn += ($lc['lc_qte']*$lc['lc_mtn']);
            }

            //On modifie le montant de la commande
            $dataUpdateCommandeMtn = $bdd->prepare("UPDATE `t_commande` SET `co_mtn`= ? WHERE `co_id` = ?");
            $dataUpdateCommandeMtn->execute([$newMtn,$id]);
            $dataUpdateCommandeMtn->closeCursor();



            $_SESSION['flash']['success'] = 'Quantité pour cette pièce modifié avec succès.';
            header('Location: page-commande-achat-edit.php?id='.$id);
            exit();
        }


    }

    //Add PIECE devis
    if(!empty($_POST) && isset($_POST['add_ligne_commande'])) {


        foreach ($_POST['pieces'] as $piece){

            //On cherche le detail de la piece select
            $dataPieceSelect = $bdd->prepare('SELECT * FROM t_piece WHERE pi_id = ?');
            $dataPieceSelect->execute([$piece]);
            $pieceSelect = $dataPieceSelect->fetch();
            $dataPieceSelect->closeCursor();

            //ON regarde si la pièce existe déjà dans les lignes du devis
            $dataPieceExiste = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ? AND lc_id_art = ?');
            $dataPieceExiste->execute([$id,$piece]);
            $existe = $dataPieceExiste->fetch();
            $nbExiste = $dataPieceExiste->RowCount();
            $dataPieceExiste->closeCursor();

            if ($nbExiste > 0){

                $newQte = $existe['lc_qte'] + 1;

                //On l'augmente
                $dataUpdatePieceUtil = $bdd->prepare("UPDATE `t_ligne_commande` SET `lc_qte`= ? WHERE `lc_id` = ?");
                $dataUpdatePieceUtil->execute([$newQte,$existe['lc_id']]);
                $dataUpdatePieceUtil->closeCursor();

            }else {

                $newQte = 1;
                //INSERT PIECE DANS DEVIS
                $dataInsDevis = $bdd->prepare("INSERT INTO `t_ligne_commande`(`lc_id_commande`, `lc_id_art`, `lc_qte`, `lc_mtn`) VALUES (?,?,?,?)");
                $dataInsDevis->execute([$id,$piece,$newQte,$pieceSelect['pi_prix']]);
                $dataInsDevis->closeCursor();
            }
        }




        //Lignes de commande
        $dataNewLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ?');
        $dataNewLigneCommande->execute([$id]);
        $newLigneCommande = $dataNewLigneCommande->fetchAll();
        $dataNewLigneCommande->closeCursor();

        $newMtn = 0;
        foreach ($newLigneCommande as $lc){
            $newMtn += ($lc['lc_qte']*$lc['lc_mtn']);
        }

        //On modifie le montant de la commande
        $dataUpdateCommandeMtn = $bdd->prepare("UPDATE `t_commande` SET `co_mtn`= ? WHERE `co_id` = ?");
        $dataUpdateCommandeMtn->execute([$newMtn,$id]);
        $dataUpdateCommandeMtn->closeCursor();

        $_SESSION['flash']['success'] = 'Pièces ajouté dans la commande avec succès.';
        header('Location: page-commande-achat-edit.php?id='.$id);
        exit();



    }

} else {

    //On chercher une commande d'achat
    $dataInsCommande = $bdd->prepare("INSERT INTO `t_commande`(`co_id_type`, `co_date`) VALUES (?,NOW())");
    $dataInsCommande->execute([2]);
    $dataInsCommande->closeCursor();

    $lastId = $bdd->lastInsertId();

    $_SESSION['flash']['success'] = 'Commande d\'achat ajouté';

    header('Location: page-commande-achat-edit.php?id='.$lastId);
    exit();


}